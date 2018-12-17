<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class LicenseController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for license
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'License', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "license_id";

        $license = License::find($parameters);
        if (count($license) == 0) {
            $this->flash->notice("The search did not find any license");

            $this->dispatcher->forward([
                "controller" => "license",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $license,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "license",
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
     * Edits a license
     *
     * @param string $license_id
     */
    public function editAction($license_id)
    {
        if (!$this->request->isPost()) {

            $license = License::findFirstBylicense_id($license_id);
            if (!$license) {
                $this->flash->error("license was not found");

                $this->dispatcher->forward([
                    'controller' => "license",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->license_id = $license->getLicenseId();

            $this->tag->setDefault("license_id", $license->getLicenseId());
            $this->tag->setDefault("po_name", $license->getPoName());
            $this->tag->setDefault("po_version", $license->getPoVersion());
            $this->tag->setDefault("license_number", $license->getLicenseNumber());
            $this->tag->setDefault("end_date", $license->getEndDate());
            
        }
    }

    /**
     * Creates a new license
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'index'
            ]);

            return;
        }

        $license = new License();
        $license->setPoName($this->request->getPost("po_name"));
        $license->setPoVersion($this->request->getPost("po_version"));
        $license->setLicenseNumber($this->request->getPost("license_number"));
        $license->setEndDate($this->request->getPost("end_date"));
        

        if (!$license->save()) {
            foreach ($license->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("license was created successfully");

        $this->dispatcher->forward([
            'controller' => "license",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a license edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'index'
            ]);

            return;
        }

        $license_id = $this->request->getPost("license_id");
        $license = License::findFirstBylicense_id($license_id);

        if (!$license) {
            $this->flash->error("license does not exist " . $license_id);

            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'index'
            ]);

            return;
        }

        $license->setPoName($this->request->getPost("po_name"));
        $license->setPoVersion($this->request->getPost("po_version"));
        $license->setLicenseNumber($this->request->getPost("license_number"));
        $license->setEndDate($this->request->getPost("end_date"));
        

        if (!$license->save()) {

            foreach ($license->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'edit',
                'params' => [$license->getLicenseId()]
            ]);

            return;
        }

        $this->flash->success("license was updated successfully");

        $this->dispatcher->forward([
            'controller' => "license",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a license
     *
     * @param string $license_id
     */
    public function deleteAction($license_id)
    {
        $license = License::findFirstBylicense_id($license_id);
        if (!$license) {
            $this->flash->error("license was not found");

            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'index'
            ]);

            return;
        }

        if (!$license->delete()) {

            foreach ($license->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "license",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("license was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "license",
            'action' => "index"
        ]);
    }

}
