<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Content\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Feeds\Addons\Content\Models\ContentModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ContentController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new ContentModel;

        $contents = $model->getFeedContent();

        $data_arr['contents'] = $contents;

        $this->html = $this->render('Feeds:Addons:Content:views:content.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
