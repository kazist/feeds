<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Category\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class CategoryModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getFeedCategory() {

        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('ffc.*');
        $query->from('#__feeds_categories', 'ffc');
        $query->where('ffc.published=1');
        $query->orderBy('ffc.id', 'DESC');

        return $query;
    }

}
