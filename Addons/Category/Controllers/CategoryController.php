<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feeds\Addons\Category\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Feeds\Addons\Category\Models\CategoryModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class CategoryController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new CategoryModel;

        $categories = $model->getFeedCategory();

        $data_arr['categories'] = $categories;

        $this->html = $this->render('Feeds:Addons:Category:views:category.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
