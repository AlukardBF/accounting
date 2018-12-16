<?php

class Equipment extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="equipment_id", type="integer", length=11, nullable=false)
     */
    public $equipment_id;

    /**
     *
     * @var string
     * @Column(column="type", type="string", length=50, nullable=false)
     */
    public $type;

    /**
     *
     * @var string
     * @Column(column="manufacturer", type="string", length=255, nullable=false)
     */
    public $manufacturer;

    /**
     *
     * @var string
     * @Column(column="specifications", type="string", nullable=false)
     */
    public $specifications;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="material_value_material_value_id", type="integer", length=11, nullable=false)
     */
    public $material_value_material_value_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("equipment");
        $this->hasMany('equipment_id', 'EquipmentHasLicense', 'equipment_equipment_id', ['alias' => 'EquipmentHasLicense']);
        $this->belongsTo('material_value_material_value_id', '\MaterialValue', 'material_value_id', ['alias' => 'MaterialValue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipment[]|Equipment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
