<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of FeedsController
 *
 * @author sbc
 */

namespace Feeds\Feeds\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Feeds\Feeds\Code\Models\FeedsModel;

class FeedsController extends BaseController {

    public function indexAction() {

        $this->model = new FeedsModel();

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);

        $data_arr['items'] = $items;

        $this->html = $this->render('Feeds:Feeds:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Feeds/generalviews/';

        $this->model = new FeedsModel();

        $item = $this->model->getRecord();
        $item = $this->model->getItemAdditionDetails($item);

        //print_r($item); exit;

        $data_arr['item'] = $item;

        $this->html = $this->render('Feeds:Feeds:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function processfeedAction() {
        $this->model = new FeedsModel();
        $this->model->processFeed();
    }

}
