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
            // Получаем запрос на основании данных введенных пользователем
            $query = Criteria::fromInput($this->di, 'License', $_POST);

            // Поиск по промежутку дат
            $endDateStart = $this->request->getPost("end_date_begin");
            // Получаем крайний нижний порог даты, если не была задана начальная
            $endDateStart = date('Y-m-d', strtotime($endDateStart));
            $endDateEnd = $this->request->getPost("end_date_end");
            $endDateEnd = date('Y-m-d', strtotime($endDateEnd));
            // Если верхний порог не был задан, прекращаем поиск
            if ($endDateEnd == "1970-01-01" && $endDateStart != "1970-01-01") {
                $this->flash->warning("При установке нижнего порога даты поиска, необходимо указать и верхний!");
                $this->dispatcher->forward([
                    "controller" => "license",
                    "action" => "index"
                ]);
                return;
            }
            // Если пользователь хотел поискать по дате лицензии
            if ($endDateStart != "1970-01-01" || $endDateEnd != "1970-01-01") {
                $query->andWhere(
                    "end_date BETWEEN :end_date_begin: AND :end_date_end:",
                    [
                        "end_date_begin" => $endDateStart,
                        "end_date_end" => $endDateEnd,
                    ],
                );
            }   
            
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
            $this->flash->notice("Поиск не дал результатов");

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
