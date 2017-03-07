<?php

namespace Feeds\Feeds\Code\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Feeds\Feeds\Code\Classes\MoreContent;
use Kazist\Service\Database\Query;

class Feeds {

    public function processFeed() {

        $feeds = $this->getFeedUrls();

        if (!empty($feeds)) {
            foreach ($feeds as $feed) {
                $this->processFeedUrl($feed);
            }
        }
    }

    public function processFeedUrl($feed) {

        $feed_xml =simplexml_load_file($feed->feed_url);// simplexml_load_string($feed_content);
        $feed_json = json_encode($feed_xml);
        $feed_array = json_decode($feed_json, TRUE);
 
        if ($feed_array['item']) {
            foreach ($feed_array['item'] as $feed_item) {
                $feed_obj = new \stdClass();

                $feed_obj->title = $feed_item['title'];
                $feed_obj->url = $feed_item['link'];
                $feed_obj->content = $feed_item['description'];
                $feed_obj->category_id = $feed->category_id;
                $feed_obj->feed_id = $feed->id;
                $feed_obj->published = true;
  
                $this->saveFeed($feed_obj, $feed->selector);
            }
        }
    }

    public function canBeAdded($allowed_categories, $feed_categories) {

        if (!is_array($allowed_categories)) {
            $allowed_categories = explode(',', $allowed_categories);
        }

        if (!is_array($feed_categories)) {
            $feed_categories = explode(',', $feed_categories);
        }

        $allowed_categories = array_map('strtolower', $allowed_categories);
        $feed_categories = array_map('strtolower', $feed_categories);

        foreach ($feed_categories as $feed_category) {
            if (in_array($feed_category, $allowed_categories)) {
                return true;
            }
        }

        return false;
    }

    public function saveFeed($feed_obj, $selector) {

        $factory = new KazistFactory;
        $morecontent = new MoreContent();

        $item = $this->getRecord($feed_obj->url);
       
        $morecontent->getMoreContent($feed_obj, $item, $selector);

        $factory->saveRecord('#__feeds_articles', $feed_obj);
    }

    public function getRecord($item_url) {
        $factory = new KazistFactory;
        $db = $factory->getDatabase();

        $query = new Query();
        $query->select('fc.*');
        $query->from('#__feeds_articles', 'fc');
        $query->where('fc.url=:url');
        $query->setParameter('url', $item_url);

        $record = $query->loadObject();

        if (is_object($record)) {
            return $record;
        } else {
            return false;
        }
    }

    public function getFeedUrls() {
        $factory = new KazistFactory;
        $db = $factory->getDatabase();

        $query = new Query();
        $query->select('ff.*');
        $query->from('#__feeds_feeds', 'ff');
        $query->where('ff.published=1');
        $query->andWhere('ff.is_processed=0 OR ff.is_processed IS NULL');
        $query->orderBy('ff.id', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(2);

        $records = $query->loadObjectList();


        return $records;
    }

}
