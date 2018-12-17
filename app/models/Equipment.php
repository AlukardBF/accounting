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
    protected $equipment_id;

    /**
     *
     * @var string
     * @Column(column="type", type="string", length=50, nullable=false)
     */
    protected $type;

    /**
     *
     * @var string
     * @Column(column="manufacturer", type="string", length=255, nullable=false)
     */
    protected $manufacturer;

    /**
     *
     * @var string
     * @Column(column="specifications", type="string", nullable=false)
     */
    protected $specifications;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="material_value_material_value_id", type="integer", length=11, nullable=false)
     */
    protected $material_value_material_value_id;

    /**
     * Method to set the value of field equipment_id
     *
     * @param integer $equipment_id
     * @return $this
     */
    public function setEquipmentId($equipment_id)
    {
        $this->equipment_id = $equipment_id;

        return $this;
    }

    /**
     * Method to set the value of field type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Method to set the value of field manufacturer
     *
     * @param string $manufacturer
     * @return $this
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Method to set the value of field specifications
     *
     * @param string $specifications
     * @return $this
     */
    public function setSpecifications($specifications)
    {
        $this->specifications = $specifications;

        return $this;
    }

    /**
     * Method to set the value of field material_value_material_value_id
     *
     * @param integer $material_value_material_value_id
     * @return $this
     */
    public function setMaterialValueMaterialValueId($material_value_material_value_id)
    {
        $this->material_value_material_value_id = $material_value_material_value_id;

        return $this;
    }

    /**
     * Returns the value of field equipment_id
     *
     * @return integer
     */
    public function getEquipmentId()
    {
        return $this->equipment_id;
    }

    /**
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Returns the value of field specifications
     *
     * @return string
     */
    public function getSpecifications()
    {
        return $this->specifications;
    }

    /**
     * Returns the value of field material_value_material_value_id
     *
     * @return integer
     */
    public function getMaterialValueMaterialValueId()
    {
        return $this->material_value_material_value_id;
    }

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

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment';
    }

}
