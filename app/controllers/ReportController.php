<?php

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ReportController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        // $this->persistent->parameters = null;
    }

    /**
     * Forecast action
     */
    public function forecastAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            // Количество дней до закупки
            $purchaseDays = $this->request->getPost("purchase_days");
            // Поиск материальных ценностей на закупку
            $queryParams = [
                "models"    => [ "MaterialValue" ],
                "columns"   => [
                    "MaterialValue.*",
                    // "MaterialValue.material_value_id",
                    // "MaterialValue.inventory_num",
                    // "MaterialValue.name",
                    // "MaterialValue.count",
                    // "MaterialValue.enter_date",
                ],
                "group"     => [ "material_value_id" ],
                "joins"     => [
                    [ "Equipment", null, null, null ],
                    [ "EquipmentHasSpecification", "Equipment.equipment_id = EquipmentHasSpecification.equipment_equipment_id", null, null ],
                    [ "Specification", "Specification.specification_id = EquipmentHasSpecification.specification_specification_id", null, null ],
                ],
                "order" => "material_value_id",
                "conditions"=> [
                    [
                        // Прогнозируем по формуле из ВКРБ
                        "(current_value / DATEDIFF(CURDATE(), enter_date) * :purchaseDays: + current_value) > expected_max_value",
                        [
                            "purchaseDays" => $purchaseDays,
                        ],
                        [
                            "purchaseDays" => PDO::PARAM_STR,
                        ],
                    ],
                ],
            ];
            $this->persistent->parameters = $queryParams;
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }
        $queryParams = $this->persistent->parameters;
        $data = (new QueryBuilder($queryParams))->getQuery()->execute();

        if (count($data) == 0) {
            $this->flash->notice("Не было найдено материальных ценностей, нуждающихся в замене");
            return $this->_redirectBack();
        }

        $paginator = new Paginator([
            'data' => $data,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }
}