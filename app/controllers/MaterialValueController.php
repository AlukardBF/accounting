<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;

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
            // Получаем запрос на основании данных введенных пользователем
            $query = Criteria::fromInput($this->di, 'MaterialValue', $_POST);

            // Поиск по промежутку дат
            $enterDateStart = $this->request->getPost("enter_date_begin");
            // Получаем крайний нижний порог даты, если не была задана начальная
            $enterDateStart = date('Y-m-d', strtotime($enterDateStart));
            $enterDateEnd = $this->request->getPost("enter_date_end");
            // В качестве верхнего порога, если не был задан, ставим текущую дату
            if ($enterDateEnd == '') {
                $enterDateEnd = $this->getCurrentDate();
            }
            $exitDateStart = $this->request->getPost("exit_date_begin");
            $exitDateStart = date('Y-m-d', strtotime($exitDateStart));
            $exitDateEnd = $this->request->getPost("exit_date_end");
            if ($exitDateEnd == '') {
                $exitDateEnd = $this->getCurrentDate();
            }
            // Добавляем поиск по дате ввода в эксплуатацию
            $query->andWhere(
                "enter_date BETWEEN :enter_date_start: AND :enter_date_end:",
                [
                    "enter_date_start" => $enterDateStart,
                    "enter_date_end" => $enterDateEnd,
                ],
            );
            // Если пользователь хотел поискать по дате списания
            if ($exitDateStart != "1970-01-01" || $exitDateEnd != $this->getCurrentDate()) {
                $query->andWhere(
                    "exit_date BETWEEN :exit_date_start: AND :exit_date_end:",
                    [
                        "exit_date_start" => $exitDateStart,
                        "exit_date_end" => $exitDateEnd,
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
    public function newAction() { }

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
            if ($furniture) {
                $this->tag->setDefault("furniture_specification", $furniture->getSpecification());
            }
            
            $equipment = $material_value->Equipment;
            if ($equipment) {
                $this->tag->setDefault("equipment_type", $equipment->getType());
                $this->tag->setDefault("equipment_manufacturer", $equipment->getManufacturer());
            }

            $this->view->material_value_id = $material_value->getMaterialValueId();
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
        // $material_value->setPhoto($this->request->getPost("photo"));
        $material_value->setLocationLocationId($this->request->getPost("location_location_id"));

        //Сохраняем мебель или оргтехнику
        if ($material_value->getType() == "furniture") {
            $furniture = new Furniture();
            $furniture->setSpecification($this->request->getPost("furniture_specification"));
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
            $material_value->Furniture = $furniture;
        } else if ($material_value->getType() == "equipment") {
            $equipment = new Equipment();
            $equipment->setType($this->request->getPost("equipment_type"));
            $equipment->setManufacturer($this->request->getPost("equipment_manufacturer"));
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
            $material_value->Equipment = $equipment;
        }

        //Проверяем картинку
        $picture = $this->request->getUploadedFiles()[0];
        $picname = $this->photoValidate($picture);
        if (!empty($picture->getName()))
            $material_value->setPhoto($picname);

        // Сохраняем мат. ценность
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

        if (!empty($picture->getName()))
            $picture->moveTo('files/photo/' . $picname);

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
        // $material_value->setPhoto($this->request->getPost("photo"));
        $material_value->setLocationLocationId($this->request->getPost("location_location_id"));

        //Сохраняем мебель или оргтехнику
        if ($material_value->getType() == "furniture") {
            $furniture = $material_value->Furniture;
            $furniture->setSpecification($this->request->getPost("furniture_specification"));
            if (!$furniture->save()) {
                foreach ($furniture->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'edit'
                ]);
                return;
            }
        } else if ($material_value->getType() == "equipment") {
            $equipment = $material_value->Equipment;
            $equipment->setType($this->request->getPost("equipment_type"));
            $equipment->setManufacturer($this->request->getPost("equipment_manufacturer"));
            $equipment->setSpecification($this->request->getPost("equipment_specification"));
            if (!$equipment->save()) {
                foreach ($equipment->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward([
                    'controller' => "material_value",
                    'action' => 'edit'
                ]);
                return;
            }
        }

        //Проверяем картинку
        $picture = $this->request->getUploadedFiles()[0];
        $picname = $this->photoValidate($picture);
        if (!empty($picture->getName()))
        {
            $old_picname = $material_value->getPhoto();
            $material_value->setPhoto($picname);
        }

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

        if (!empty($picture->getName()))
        {
            $picture->moveTo('files/photo/' . $picname);
            if (!empty($old_picname))
                unlink('files/photo/' . $old_picname);
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

        $old_picname = $material_value->getPhoto();

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

        if (!empty($old_picname))
            unlink('files/photo/' . $old_picname);

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
        $equipment = MaterialValue::findFirstBymaterial_value_id($material_value_id)->Equipment;
        if (isset($equipment)) {
            $licenses = $equipment->License;
            if (isset($licenses))
                $this->view->licenses = $licenses;
            $specifications = $equipment->EquipmentHasSpecification;
            if (isset($specifications))
                $this->view->specifications = $specifications;
        }
    }

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
            // Устанавливаем уровень коррекции ошибок в HIGH
            $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
            $this->view->disable();
            $this->response->setFileToSend($qrCode->writeDataUri(), 'qr-'.$material_value_id.'.png')->send();
        }
    }

    /**
     * Licenses setup
     * 
     * @param string $material_value_id
     */
    public function licensesAction($material_value_id)
    {
        $this->view->material_value_id = $material_value_id;
    }
    /**
     * Search licenses
     */
    public function search_licensesAction()
    {
        $id = $this->request->getPost("material_value_id");

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
            $this->flash->notice("Поиск не дал результатов");

            $this->dispatcher->forward([
                "controller" => "material_value",
                "action" => "licenses",
                "params" => [ $id ],
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $license,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        
        $this->dispatcher->forward([
            "controller" => "material_value",
            "action" => "licenses",
            "params" => [ $id ],
        ]);

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * Add EquipmentHasLicense from ajax
     */
    public function add_licenseAction($material_value_id, $license_id)
    {
        if ($this->request->isAjax()) {
            $equipment = MaterialValue::findFirstBymaterial_value_id($material_value_id)->Equipment;
            if (isset($equipment)) {
                $equipmentHasLicense = new EquipmentHasLicense();
                $equipmentHasLicense->Equipment = $equipment;
                $equipmentHasLicense->License = License::findFirstBylicense_id($license_id);
                if ($equipmentHasLicense->save()) {
                    $message = "Связь добавлена успешно";
                } else {
                    $message = "Ошибка при сохранении связи лицензии и оргтехники";
                }
            } else {
                $message = "Не найдена оргтехника";
            }
            $this->view->disable();
            echo $message;
            return false;
        }        
    }
    /**
     * Remove EquipmentHasLicense from ajax
     */
    public function rem_licenseAction($material_value_id, $license_id)
    {
        if ($this->request->isAjax()) {
            $equipment_id = MaterialValue::findFirstBymaterial_value_id($material_value_id)->getEquipmentEquipmentId();
            if (isset($equipment_id)) {
                $equipmentHasLicense = EquipmentHasLicense::findFirst(
                    [
                        'equipment_equipment_id = ?1 AND license_license_id = ?2',
                        'bind' => [
                            1 => $equipment_id,
                            2 => $license_id,
                        ],
                    ]
                );
                if (isset($equipmentHasLicense)) {
                    if ($equipmentHasLicense->delete()) {
                        $message = "Связь успешно удалена";
                    } else {
                        $message = "Ошибка при удалении связи лицензии и оргтехники";
                    }
                } else {
                    $message = "Не найдена связь лицензии и оргтехники";
                }
            } else {
                $message = "Не найдена оргтехника";
            }
            $this->view->disable();
            echo $message;
            return false;
        }        
    }

    /**
     * Specification setup
     * 
     * @param string $material_value_id
     */
    public function specificationsAction($material_value_id)
    {
        $this->view->material_value_id = $material_value_id;
    }
    /**
     * Search specification
     */
    public function search_specificationsAction()
    {
        $id = $this->request->getPost("material_value_id");

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
                "controller" => "material_value",
                "action" => "specifications",
                "params" => [ $id ],
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $specification,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->dispatcher->forward([
            "controller" => "material_value",
            "action" => "specifications",
            "params" => [ $id ],
        ]);

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * Add EquipmentHasSpecification from ajax
     */
    public function add_specificationAction($material_value_id, $specification_id, $spec_value)
    {
        if ($this->request->isAjax()) {
            if (empty($spec_value))
                return false;
            $equipment = MaterialValue::findFirstBymaterial_value_id($material_value_id)->Equipment;
            if (isset($equipment)) {
                $equipmentHasSpecification = new EquipmentHasSpecification();
                $equipmentHasSpecification->Equipment = $equipment;
                $equipmentHasSpecification->Specification = Specification::findFirstByspecification_id($specification_id);
                $equipmentHasSpecification->setCurrentValue($spec_value);
                if ($equipmentHasSpecification->save()) {
                    $message = "Связь добавлена успешно";
                } else {
                    $message = "Ошибка при сохранении связи характеристики и оргтехники";
                }
            } else {
                $message = "Не найдена оргтехника";
            }
            $this->view->disable();
            echo $message;
            return false;
        }        
    }
    /**
     * Remove EquipmentHasSpecification from ajax
     */
    public function rem_specificationAction($material_value_id, $specification_id)
    {
        if ($this->request->isAjax()) {
            $equipment_id = MaterialValue::findFirstBymaterial_value_id($material_value_id)->getEquipmentEquipmentId();
            if (isset($equipment_id)) {
                $equipmentHasSpecification = EquipmentHasSpecification::findFirst(
                    [
                        'equipment_equipment_id = ?1 AND specification_specification_id = ?2',
                        'bind' => [
                            1 => $equipment_id,
                            2 => $specification_id,
                        ],
                    ]
                );
                if (isset($equipmentHasSpecification)) {
                    if ($equipmentHasSpecification->delete()) {
                        $message = "Связь успешно удалена";
                    } else {
                        $message = "Ошибка при удалении связи характеристики и оргтехники";
                    }
                } else {
                    $message = "Не найдена связь лицензии и оргтехники";
                }
            } else {
                $message = "Не найдена оргтехника";
            }
            $this->view->disable();
            echo $message;
            return false;
        }        
    }

    private function photoValidate($picture)
    {
        /* Сохранение картинки */
        /* Проверяем загруженный файл */
        $validation = new \Phalcon\Validation();
        $file = new \Phalcon\Validation\Validator\File([
            'maxSize' => '2M',
            'messageSize' => 'Загруженная картинка превышает максимально допустимый размер файла (:max)',
            'allowedTypes' => ['image/jpeg', 'image/png'],
            'messageType' => 'Ваша картинка должна быть в формате JPEG или PNG',
            'allowEmpty' => true
        ]);
        $validation->add('photo',$file);
        $messages = $validation->validate($picture);
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
            // $this->dispatcher->forward([
            //     'controller' => "material_value",
            //     'action' => 'index'
            // ]);
            $this->_forwardBack();
            return;
        }
        /* Если нет ошибки в загруженном файле - продолжаем выполнение */
        //Если файл не загрузили
        if (!empty($picture->getName()))
        {
            $random = new \Phalcon\Security\Random();
            return $random->hex(10) . '.' . $picture->getExtension();
        }
        return null;
    }
}
