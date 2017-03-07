<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Url\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Feeds\Addons\Url\Models\UrlModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class UrlController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new UrlModel;

        $urls = $model->getFeedUrl();

        $data_arr['urls'] = $urls;

        $this->html = $this->render('Feeds:Addons:Url:views:url.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
