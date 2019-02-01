<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Endroid\QrCode\QrCode;
use Phalcon\Mvc\Url;

class MaterialValueController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for material_value
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'MaterialValue', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "material_value_id";

        $material_value = MaterialValue::find($parameters);
        if (count($material_value) == 0) {
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "material_value",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $material_value,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "material_value",
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
     * Edits a material_value
     *
     * @param string $material_value_id
     */
    public function editAction($material_value_id)
    {
        if (!$this->request->isPost()) {

            $material_value = MaterialValue::findFirstBymaterial_value_id($material_value_id);
            if (!$material_value) {
                $this->flash->error("Материальная ценность не найдена");

                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->material_value_id = $material_value->getMaterialValueId();
            $photo = $material_value->getPhoto();
            if ($photo != null)
                $this->view->photo = $photo;

            $this->tag->setDefault("material_value_id", $material_value->getMaterialValueId());
            $this->tag->setDefault("type", $material_value->getType());
            $this->tag->setDefault("inventory_num", $material_value->getInventoryNum());
            $this->tag->setDefault("serial_num", $material_value->getSerialNum());
            $this->tag->setDefault("name", $material_value->getName());
            $this->tag->setDefault("description", $material_value->getDescription());
            $this->tag->setDefault("price", $material_value->getPrice());
            $this->tag->setDefault("count", $material_value->getCount());
            $this->tag->setDefault("enter_date", $material_value->getEnterDate());
            $this->tag->setDefault("exit_date", $material_value->getExitDate());
            $this->tag->setDefault("photo", $material_value->getPhoto());
            $this->tag->setDefault("location_location_id", $material_value->getLocationLocationId());

            $furniture = $material_value->Furniture;
            if (isset($furniture[0])) {
                $this->tag->setDefault("furniture_specification", $furniture[0]->getSpecifications());
            }
            
            $equipment = $material_value->Equipment;
            if (isset($equipment[0])) {
                $this->tag->setDefault("equipment_type", $equipment[0]->getType());
                $this->tag->setDefault("equipment_manufacturer", $equipment[0]->getManufacturer());
                $this->tag->setDefault("equipment_specifications", $equipment[0]->getSpecifications());
            }
        }
    }

    /**
     * Creates a new material_value
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'index'
            ]);

            return;
        }

        $material_value = new MaterialValue();
        $material_value->setType($this->request->getPost("type"));
        $material_value->setInventoryNum($this->request->getPost("inventory_num"));
        $material_value->setSerialNum($this->request->getPost("serial_num"));
        $material_value->setName($this->request->getPost("name"));
        $material_value->setDescription($this->request->getPost("description"));
        $material_value->setPrice($this->request->getPost("price"));
        $material_value->setCount($this->request->getPost("count"));
        $material_value->setEnterDate($this->request->getPost("enter_date"));
        $material_value->setExitDate($this->request->getPost("exit_date"));
        $material_value->setPhoto($this->request->getPost("photo"));
        $material_value->setLocationLocationId($this->request->getPost("location_location_id"));

        if (!$material_value->save()) {
            foreach ($material_value->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'new'
            ]);

            return;
        }

        //Сохраняем мебель или оргтехнику
        if ($material_value->getType() == "furniture") {
            $furniture = new Furniture();
            $furniture->setSpecifications($this->request->getPost("furniture_specifications"));
            $furniture->setMaterialValueMaterialValueId($material_value->getMaterialValueId());
            //Сохраняем
            if (!$furniture->save()) {
                foreach ($furniture->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'new'
                ]);
                return;
            }
        } else if ($material_value->getType() == "equipment") {
            $equipment = new Equipment();
            $equipment->setType($this->request->getPost("equipment_type"));
            $equipment->setManufacturer($this->request->getPost("equipment_manufacturer"));
            $equipment->setSpecifications($this->request->getPost("equipment_specifications"));
            $equipment->setMaterialValueMaterialValueId($material_value->getMaterialValueId());
            //Сохраняем
            if (!$equipment->save()) {
                foreach ($equipment->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'new'
                ]);
                return;
            }
        }

        $this->flash->success("Материальная ценность успешно добавлена");

        $this->dispatcher->forward([
            'controller' => "material_value",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a material_value edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'index'
            ]);

            return;
        }

        $material_value_id = $this->request->getPost("material_value_id");
        $material_value = MaterialValue::findFirstBymaterial_value_id($material_value_id);

        if (!$material_value) {
            $this->flash->error("Материальная ценность с таким id не найдена: " . $material_value_id);

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'index'
            ]);

            return;
        }

        $material_value->setType($this->request->getPost("type"));
        $material_value->setInventoryNum($this->request->getPost("inventory_num"));
        $material_value->setSerialNum($this->request->getPost("serial_num"));
        $material_value->setName($this->request->getPost("name"));
        $material_value->setDescription($this->request->getPost("description"));
        $material_value->setPrice($this->request->getPost("price"));
        $material_value->setCount($this->request->getPost("count"));
        $material_value->setEnterDate($this->request->getPost("enter_date"));
        $material_value->setExitDate($this->request->getPost("exit_date"));
        $material_value->setPhoto($this->request->getPost("photo"));
        $material_value->setLocationLocationId($this->request->getPost("location_location_id"));

        if (!$material_value->save()) {

            foreach ($material_value->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'edit',
                'params' => [$material_value->getMaterialValueId()]
            ]);

            return;
        }

        if ($material_value->getType() == "furniture") {
            //Добавить
            $furniture->setSpecifications($this->request->getPost("furniture_specifications"));
            $furniture->setMaterialValueMaterialValueId($material_value->getMaterialValueId());
            //Сохраняем
            if (!$furniture->save()) {
                foreach ($furniture->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'new'
                ]);
                return;
            }
        } else if ($material_value->getType() == "equipment") {
            $equipment = new Equipment();
            $equipment->setType($this->request->getPost("equipment_type"));
            $equipment->setManufacturer($this->request->getPost("equipment_manufacturer"));
            $equipment->setSpecifications($this->request->getPost("equipment_specifications"));
            $equipment->setMaterialValueMaterialValueId($material_value->getMaterialValueId());
            //Сохраняем
            if (!$equipment->save()) {
                foreach ($equipment->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'new'
                ]);
                return;
            }
        }

        $this->flash->success("Материальная ценность обновлена");

        $this->dispatcher->forward([
            'controller' => "material_value",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a material_value
     *
     * @param string $material_value_id
     */
    public function deleteAction($material_value_id)
    {
        $material_value = MaterialValue::findFirstBymaterial_value_id($material_value_id);
        if (!$material_value) {
            $this->flash->error("Материальная ценность не найдена");

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'index'
            ]);

            return;
        }

        if (!$material_value->delete()) {

            foreach ($material_value->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Материальная ценность удалена");

        $this->dispatcher->forward([
            'controller' => "material_value",
            'action' => "index"
        ]);
    }

    /**
     * Show a material_value
     *
     * @param string $material_value_id
     */
    public function showAction($material_value_id)
    {
        $this->editAction($material_value_id);
    }
        /*$material_value = MaterialValue::findFirstBymaterial_value_id($material_value_id);
        if (!$material_value) {
            $this->flash->error("material_value was not found");

            $this->dispatcher->forward([
                'controller' => "material_value",
                'action' => 'index'
            ]);

            return;
        }

        $this->view->material_value_id = $material_value->getMaterialValueId();
        $photo = $material_value->getPhoto();
        if ($photo != null)
            $this->view->photo = $photo;

        $this->tag->setDefault("material_value_id", $material_value->getMaterialValueId());
        $this->tag->setDefault("type", $material_value->getType());
        $this->tag->setDefault("inventory_num", $material_value->getInventoryNum());
        $this->tag->setDefault("serial_num", $material_value->getSerialNum());
        $this->tag->setDefault("name", $material_value->getName());
        $this->tag->setDefault("description", $material_value->getDescription());
        $this->tag->setDefault("price", $material_value->getPrice());
        $this->tag->setDefault("count", $material_value->getCount());
        $this->tag->setDefault("enter_date", $material_value->getEnterDate());
        $this->tag->setDefault("exit_date", $material_value->getExitDate());
        $this->tag->setDefault("photo", $material_value->getPhoto());
        $this->tag->setDefault("location_location_id", $material_value->getLocationLocationId());

        $furniture = $material_value->Furniture;
        if (isset($furniture[0])) {
            $this->tag->setDefault("furniture_specification", $furniture->getSpecifications());
        }
        
        $equipment = $material_value->Equipment;
        if (isset($equipment[0])) {
            $this->tag->setDefault("equipment_type", $equipment[0]->getType());
            $this->tag->setDefault("equipment_manufacturer", $equipment[0]->getManufacturer());
            $this->tag->setDefault("equipment_specifications", $equipment[0]->getSpecifications());
        }
    }*/

    /**
     * Generate and return QR code by requested uri
     *
     * @param string $material_value_id
     * @return Image|null
     */
    public function qrAction($material_value_id)
    {
        if ($material_value_id != null) {
            // Формируем ссылку
            $url = $this->request->getScheme() . "://" . $this->request->getHttpHost() . $this->url->getStatic() . 'material_value/show/' . $material_value_id;
            // Генерируем QR code
            $qrCode = new QrCode($url);
            $this->response->setFileToSend($qrCode->writeDataUri(), 'qr-'.$material_value_id.'.png')->send();
        }
    }
}
