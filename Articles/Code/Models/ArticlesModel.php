<?php

namespace Feeds\Articles\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

/**
 * Model to get data for the issue list view
 *
 * @since  1.0
 */
class ArticlesModel extends BaseModel {

    public function processFeed() {

        $feed = new Feed;

        $feed->processFeed();
    }

    public function getContents($offset = 0, $limit = 3) {

        $factory = new KazistFactory();

        $session = $factory->getSession();

        //$email->debug_exit = true;
        $uri = $session->get('uri');

        $query = new Query();
        $query->select('fc.*');
        $query->from('#__feeds_contents', 'fc');
        $query->orderBy('id ', 'DESC');

        $query->setFirstResult($offset);
        $query->setMaxResults($limit);


        $records = $query->loadObjectList();

        return $this->getAdditionalDetail($records);
    }

    public function getTotalContents() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('COUNT(*) AS total');
        $query->from('#__feeds_contents', 'fc');


        $record = $query->loadObject();

        return $record->total;
    }

    //put your code here
    public function getAdditionalDetail($items) {

        $tmp_array = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $tmp_array[] = $this->getItemAdditionDetails($item);
            }
        }

        return $tmp_array;
    }

    public function getItemAdditionDetails($item) {
        $factory = new KazistFactory();

        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);

        return $item_obj;
    }

    public function loadContents() {
        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();


        $offset = $this->request->request->get('offset');
        $category_id = $this->request->request->get('category_id');
        $action = $this->request->request->get('action');
        $limit = $this->request->request->get('limit');

        $object_arr->category_id = $category_id;
        $object_arr->action = $action;
        $object_arr->limit = $limit;
        $object_arr->offset = ($action == 'previous') ? $offset - $limit : $offset + $limit;

        $template = 'content.list.twig';
        $this->twig_paths[] = realpath(JPATH_ROOT . '/applications/Feeds/generalviews');
        $html = $factory->renderData($object_arr, $template, $paths);


        return $html;
    }

}
