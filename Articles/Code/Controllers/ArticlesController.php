<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of ArticlesController
 *
 * @author sbc
 */

namespace Feeds\Articles\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;

class ArticlesController extends BaseController {

    public function indexAction() {

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);

        $data_arr['items'] = $items;

        $this->html = $this->render('Feeds:Articles:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function detailAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Feeds/generalviews/';

        $item = $this->model->getRecord();
        $item = $this->model->getItemAdditionDetails($item);

        $data_arr['item'] = $item;

        $this->html = $this->render('Feeds:Articles:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
