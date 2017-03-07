<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Content\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ContentModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getFeedContent() {

        $query = $this->getQuery();

        $query->setFirstResult(0);
        $query->setMaxResults(5);

        $records = $query->loadObjectList();


        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('fc.*, mm.file as content_file');
        $query->from('#__feeds_contents', 'fc');
        $query->leftJoin('fc', '#__media_media', 'mm', 'mm.id = fc.image');
        $query->where('fc.published=1');
        $query->orderBy('fc.id', 'DESC');

        return $query;
    }

}
