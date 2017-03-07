<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\MenuFeeds\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Feeds\ContentCode\Models\ArticlesModel;

class MenufeedModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getFeeds() {

        $factory = new KazistFactory();
        $contentModel = new ArticlesModel();
        $db = $factory->getDbo();

        $query = $factory->getQueryBuilder('#__feed_articles', 'fa');

        $query->having('image_file<>\'\'');

        $query->setFirstResult(0);
        $query->setMaxResults(4);

        $records = $query->loadObjectList();
        $records = $contentModel->getAdditionalDetail($records);


        return $records;
    }

}
