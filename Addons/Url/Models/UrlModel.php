<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Url\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class UrlModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getFeedUrl() {

        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('ff.*');
        $query->from('#__feeds_feeds', 'ff');
        $query->where('ff.published=1');
        $query->orderBy('ff.id ', 'DESC');

        return $query;
    }

}
