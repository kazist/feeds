<?php

namespace Feeds\Feeds\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Feeds\Feeds\Code\Classes\Feeds;

/**
 * Model to get data for the issue list view
 *
 * @since  1.0
 */
class FeedsModel extends BaseModel {

    public function processFeed() {

        $feed = new Feeds;

        $feed->processFeed();
    }

    //put your code here
    public function getAdditionalDetail($items) {

        $tmp_array = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $tmp_array[] = $this->getItemAdditionDetails($item);
            }
        }

        return $tmp_array;
    }

    public function getItemAdditionDetails($item) {
        $factory = new KazistFactory();

        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);
        $item_obj->media = $factory->getMedia($item->image);
        $item_obj->total_contents = $this->getCountCategoryFeeds($item->id);
        $item_obj->contents = $this->getCategoryFeedContents($item->id);

        return $item_obj;
    }

}
