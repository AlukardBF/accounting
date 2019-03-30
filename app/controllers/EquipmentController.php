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
        $this->persistent->parameters = null;
    }

    /**
     * Searches for equipment
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Equipment', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "equipment_id";

        $equipment = Equipment::find($parameters);
        if (count($equipment) == 0) {
            $this->flash->notice("The search did not find any equipment");

            $this->dispatcher->forward([
                "controller" => "equipment",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $equipment,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "equipment",
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
     * Edits a equipment
     *
     * @param string $equipment_id
     */
    public function editAction($equipment_id)
    {
        if (!$this->request->isPost()) {

            $equipment = Equipment::findFirstByequipment_id($equipment_id);
            if (!$equipment) {
                $this->flash->error("equipment was not found");

                $this->dispatcher->forward([
                    'controller' => "equipment",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->equipment_id = $equipment->getEquipmentId();

            $this->tag->setDefault("equipment_id", $equipment->getEquipmentId());
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

        $this->flash->success("equipment was created successfully");

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
        $equipment = Equipment::findFirstByequipment_id($equipment_id);

        if (!$equipment) {
            $this->flash->error("equipment does not exist " . $equipment_id);

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

        $this->flash->success("equipment was updated successfully");

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
        $equipment = Equipment::findFirstByequipment_id($equipment_id);
        if (!$equipment) {
            $this->flash->error("equipment was not found");

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

        $this->flash->success("equipment was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => "index"
        ]);
    }

}
