<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class LocationController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        // $this->persistent->parameters = null;
    }

    /**
     * Searches for location
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Location', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "location_id";

        $location = Location::find($parameters);
        if (count($location) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "location",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $location,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "location",
            "action" => "index"
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a location
     *
     * @param string $location_id
     */
    public function editAction($location_id)
    {
        if (!$this->request->isPost()) {

            $location = Location::findFirstBylocation_id($location_id);
            if (!$location) {
                $this->flash->error("Местоположение не найдено");

                $this->dispatcher->forward([
                    'controller' => "location",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->location_id = $location->getLocationId();

            $this->tag->setDefault("location_id", $location->getLocationId());
            $this->tag->setDefault("campus", $location->getCampus());
            $this->tag->setDefault("auditory", $location->getAuditory());

        }
    }

    /**
     * Creates a new location
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'index'
            ]);

            return;
        }

        $location = new Location();
        $location->setCampus($this->request->getPost("campus"));
        $location->setAuditory($this->request->getPost("auditory"));


        if (!$location->save()) {
            foreach ($location->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Местоположение успешно добавлено");

        $this->dispatcher->forward([
            'controller' => "location",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a location edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'index'
            ]);

            return;
        }

        $location_id = $this->request->getPost("location_id");
        $location = Location::findFirstBylocation_id($location_id);

        if (!$location) {
            $this->flash->error("Местоположение с таким id не существует: " . $location_id);

            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'index'
            ]);

            return;
        }

        $location->setCampus($this->request->getPost("campus"));
        $location->setAuditory($this->request->getPost("auditory"));


        if (!$location->save()) {

            foreach ($location->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'edit',
                'params' => [$location->getLocationId()]
            ]);

            return;
        }

        $this->flash->success("Местоположение успешно обновлено");

        $this->dispatcher->forward([
            'controller' => "location",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a location
     *
     * @param string $location_id
     */
    public function deleteAction($location_id)
    {
        $location = Location::findFirstBylocation_id($location_id);
        if (!$location) {
            $this->flash->error("Местоположение не найдено");

            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'index'
            ]);

            return;
        }

        if (!$location->delete()) {

            foreach ($location->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "location",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Местоположение успешно удалено");

        $this->dispatcher->forward([
            'controller' => "location",
            'action' => "index"
        ]);
    }

}
