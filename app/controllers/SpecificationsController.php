<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class SpecificationsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for specifications
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Specifications', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "specifications_id";

        $specifications = Specifications::find($parameters);
        if (count($specifications) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "specifications",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $specifications,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "specifications",
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
     * Edits a specification
     *
     * @param string $specifications_id
     */
    public function editAction($specifications_id)
    {
        if (!$this->request->isPost()) {

            $specification = Specifications::findFirstByspecifications_id($specifications_id);
            if (!$specification) {
                $this->flash->error("specification was not found");

                $this->dispatcher->forward([
                    'controller' => "specifications",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->specifications_id = $specification->getSpecificationsId();

            $this->tag->setDefault("specifications_id", $specification->getSpecificationsId());
            $this->tag->setDefault("name", $specification->getName());
            $this->tag->setDefault("expected_max_value", $specification->getExpectedMaxValue());
            
        }
    }

    /**
     * Creates a new specification
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'index'
            ]);

            return;
        }

        $specification = new Specifications();
        $specification->setName($this->request->getPost("name"));
        $specification->setExpectedMaxValue($this->request->getPost("expected_max_value"));
        

        if (!$specification->save()) {
            foreach ($specification->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("specification was created successfully");

        $this->dispatcher->forward([
            'controller' => "specifications",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a specification edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'index'
            ]);

            return;
        }

        $specifications_id = $this->request->getPost("specifications_id");
        $specification = Specifications::findFirstByspecifications_id($specifications_id);

        if (!$specification) {
            $this->flash->error("specification does not exist " . $specifications_id);

            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'index'
            ]);

            return;
        }

        $specification->setName($this->request->getPost("name"));
        $specification->setExpectedMaxValue($this->request->getPost("expected_max_value"));
        

        if (!$specification->save()) {

            foreach ($specification->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'edit',
                'params' => [$specification->getSpecificationsId()]
            ]);

            return;
        }

        $this->flash->success("specification was updated successfully");

        $this->dispatcher->forward([
            'controller' => "specifications",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a specification
     *
     * @param string $specifications_id
     */
    public function deleteAction($specifications_id)
    {
        $specification = Specifications::findFirstByspecifications_id($specifications_id);
        if (!$specification) {
            $this->flash->error("specification was not found");

            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'index'
            ]);

            return;
        }

        if (!$specification->delete()) {

            foreach ($specification->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "specifications",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("specification was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "specifications",
            'action' => "index"
        ]);
    }

}
