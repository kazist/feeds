<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\LatestFeeds\Models;

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class LatestfeedModel {

    public $block_id = '';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getContent() {

        $query = new Query();
        $factory = new KazistFactory;

        $category = $factory->getSetting('feed.block.latestcontent.category', $this->flexview_id);

        $query->select('ca.*, mm.file as content_image');
        $query->from('#__feeds_contents', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', ' mm.id = ca.image');
        // $query->leftJoin('ca', '#__users_users', 'uu', 'uu.id = ca.created_by');

        $query->where('ca.image>0');
        if ((int) $category) {
            $query->andWhere('ca.category_id=:category_id');
            $query->setParameter('category_id', $category);
        }

        $query->andWhere('ca.published=1');
        $query->orderBy('ca.date_created', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(5);

        $records = $query->loadObjectList();

        return $records;
    }

}
