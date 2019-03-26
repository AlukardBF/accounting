<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class SpecificationController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for specification
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Specification', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "specification_id";

        $specification = Specification::find($parameters);
        if (count($specification) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "specification",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $specification,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "specification",
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
     * @param string $specification_id
     */
    public function editAction($specification_id)
    {
        if (!$this->request->isPost()) {

            $specification = Specification::findFirstByspecification_id($specification_id);
            if (!$specification) {
                $this->flash->error("specification was not found");

                $this->dispatcher->forward([
                    'controller' => "specification",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->specification_id = $specification->getSpecificationId();

            $this->tag->setDefault("specification_id", $specification->getSpecificationId());
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
                'controller' => "specification",
                'action' => 'index'
            ]);

            return;
        }

        $specification = new Specification();
        $specification->setName($this->request->getPost("name"));
        $specification->setExpectedMaxValue($this->request->getPost("expected_max_value"));
        

        if (!$specification->save()) {
            foreach ($specification->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "specification",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("specification was created successfully");

        $this->dispatcher->forward([
            'controller' => "specification",
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
                'controller' => "specification",
                'action' => 'index'
            ]);

            return;
        }

        $specification_id = $this->request->getPost("specification_id");
        $specification = Specification::findFirstByspecification_id($specification_id);

        if (!$specification) {
            $this->flash->error("specification does not exist " . $specification_id);

            $this->dispatcher->forward([
                'controller' => "specification",
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
                'controller' => "specification",
                'action' => 'edit',
                'params' => [$specification->getSpecificationId()]
            ]);

            return;
        }

        $this->flash->success("specification was updated successfully");

        $this->dispatcher->forward([
            'controller' => "specification",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a specification
     *
     * @param string $specification_id
     */
    public function deleteAction($specification_id)
    {
        $specification = Specification::findFirstByspecification_id($specification_id);
        if (!$specification) {
            $this->flash->error("specification was not found");

            $this->dispatcher->forward([
                'controller' => "specification",
                'action' => 'index'
            ]);

            return;
        }

        if (!$specification->delete()) {

            foreach ($specification->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "specification",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("specification was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "specification",
            'action' => "index"
        ]);
    }

}
