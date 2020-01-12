<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class EquipmentController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        // $this->persistent->parameters = null;
    }

    /**
     * Searches for equipment
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $parameters = [];
            foreach ($_POST as $key => $value) {
                if ($value !== '') {
                    $parameters[$key] = $value;
                }
            }
            $this->persistent->parameters = empty($parameters) ? null : $parameters;
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters["conditions"] = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "equipment_id";

        $equipment = Equipment::find($parameters);
        if (count($equipment) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "equipment",
                "action" => "index"
            ]);

            return;
        }

        $this->dispatcher->forward([
            "controller" => "equipment",
            "action" => "index"
        ]);

        $this->view->page = $equipment;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a equipment
     *
     * @param string $equipment_id
     */
    public function editAction($equipment_id)
    {
        if (!$this->request->isPost()) {

            $equipment = Equipment::findById($equipment_id);
            if (!$equipment) {
                $this->flash->error("Оргтехника не найдена");

                $this->dispatcher->forward([
                    'controller' => "equipment",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->equipment_id = $equipment->getEquipmentId();

            $this->tag->setDefault("equipment_id", strval($equipment->getEquipmentId()));
            $this->tag->setDefault("type", $equipment->getType());
            $this->tag->setDefault("manufacturer", $equipment->getManufacturer());
        }
    }

    /**
     * Creates a new equipment
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $equipment = new Equipment();
        $equipment->setType($this->request->getPost("type"));
        $equipment->setManufacturer($this->request->getPost("manufacturer"));

        if (!$equipment->save()) {
            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Оргтехника успешна добавлена");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a equipment edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $equipment_id = $this->request->getPost("equipment_id");
        $equipment = Equipment::findById($equipment_id);

        if (!$equipment) {
            $this->flash->error("Оргтехника с таким id не найдена: " . $equipment_id);

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $equipment->setType($this->request->getPost("type"));
        $equipment->setManufacturer($this->request->getPost("manufacturer"));

        if (!$equipment->save()) {

            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'edit',
                'params' => [$equipment->getEquipmentId()]
            ]);

            return;
        }

        $this->flash->success("Оргтехника успешно обновлена");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a equipment
     *
     * @param string $equipment_id
     */
    public function deleteAction($equipment_id)
    {
        $equipment = Equipment::findById($equipment_id);
        if (!$equipment) {
            $this->flash->error("Оргтехника не найдена");

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        if (!$equipment->delete()) {

            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Оргтехника успешно удалена");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => "index"
        ]);
    }

}
