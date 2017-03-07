<?php

namespace Feeds\Feeds\Code\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;
use Joomla\Uri\Uri;
use Kazist\Service\Media\MediaManager;

class MoreContent {

    public $content = '';
    public $largest_img = '';
    public $largest_size = '';
    public $media_id = '';

    public function getMoreContent($feed_obj, $item, $selector) {

        $this->content = ($selector !== '') ? file_get_contents($feed_obj->url) : $feed_obj->content;
        $this->media_id = $item->image;

        list($image, $content) = $this->getBodyContent($feed_obj, $selector);
        $feed_obj->image = $image;

        if ($selector !== '') {
            $feed_obj->content = $content;
        }
    }

    public function getBodyContent($feed_obj, $selector) {

        $crawler = new Crawler();

        $crawler->add(file_get_contents($feed_obj->url));
        $content_section = $crawler->filter($selector);

        $content_arr = $content_section
                ->filter('p')
                ->each(function (Crawler $nodeCrawler) {

            return '<p>' . $nodeCrawler->text() . '</p>';
        });


        $image_arr = $content_section
                ->filter('img')
                ->each(function (Crawler $nodeCrawler) {

            return $nodeCrawler->extract('src');
        });

        $image = $this->getlargestImage($feed_obj, $image_arr);

        $content = implode('', $content_arr);

        return array($image, $content);
    }

    public function getlargestImage($feed_obj, $image_arr) {

        $uri = parse_url($feed_obj->url);
        $mediamanager = new MediaManager();

        foreach ($image_arr as $key => $image) {

            $image_uri = parse_url($image[0]);
            $this->largest_img = ($image_uri['host']) ? $image[0] : 'http://' . $uri['host'] . '/' . $image[0];

            break;
        }

        $upload_url = $mediamanager->getUploadDir('feeds/articles/' . $feed_obj->id);

        $largest_img = array_reverse(explode('/', $this->largest_img));
        //print_r( JPATH_ROOT .'/'. $upload_url . $largest_img[0]);

        $ch = curl_init($this->largest_img);
        $fp = fopen(JPATH_ROOT . $upload_url . $largest_img[0], 'w+');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $mediamanager->updateMedia($this->media_id, 'feeds.articles', 'image', $largest_img[0], $upload_url . $largest_img[0]);
    }

}
