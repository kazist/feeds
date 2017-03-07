<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\LatestFeeds\Controllers;

use Kazist\Controller\AddonController;
use Feeds\Addons\LatestFeeds\Models\LatestfeedModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class LatestfeedController extends AddonController {

    public $flexview_id = '';

    function indexAction($offset = 0, $limit = 6) {

        $model = new LatestfeedModel;

        $model->flexview_id = $this->flexview_id;

        $contents = $model->getContent();

        $most_latest_contents = $contents[0];
        unset($contents[0]);
        $latest_contents = $contents;

        $data_arr['latest_contents'] = $latest_contents;
        $data_arr['most_latest_contents'] = $most_latest_contents;

        $this->html = $this->render('Feeds:Addons:LatestFeeds:views:latestFeeds.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
