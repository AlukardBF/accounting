<?php

class EquipmentHasSpecifications extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="equipment_equipment_id", type="integer", length=11, nullable=false)
     */
    protected $equipment_equipment_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="specifications_specifications_id", type="integer", length=11, nullable=false)
     */
    protected $specifications_specifications_id;

    /**
     *
     * @var string
     * @Column(column="current_value", type="string", nullable=false)
     */
    protected $current_value;

    /**
     * Method to set the value of field equipment_equipment_id
     *
     * @param integer $equipment_equipment_id
     * @return $this
     */
    public function setEquipmentEquipmentId($equipment_equipment_id)
    {
        $this->equipment_equipment_id = $equipment_equipment_id;

        return $this;
    }

    /**
     * Method to set the value of field specifications_specifications_id
     *
     * @param integer $specifications_specifications_id
     * @return $this
     */
    public function setSpecificationsSpecificationsId($specifications_specifications_id)
    {
        $this->specifications_specifications_id = $specifications_specifications_id;

        return $this;
    }

    /**
     * Method to set the value of field current_value
     *
     * @param string $current_value
     * @return $this
     */
    public function setCurrentValue($current_value)
    {
        $this->current_value = $current_value;

        return $this;
    }

    /**
     * Returns the value of field equipment_equipment_id
     *
     * @return integer
     */
    public function getEquipmentEquipmentId()
    {
        return $this->equipment_equipment_id;
    }

    /**
     * Returns the value of field specifications_specifications_id
     *
     * @return integer
     */
    public function getSpecificationsSpecificationsId()
    {
        return $this->specifications_specifications_id;
    }

    /**
     * Returns the value of field current_value
     *
     * @return string
     */
    public function getCurrentValue()
    {
        return $this->current_value;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("equipment_has_specifications");
        $this->belongsTo('equipment_equipment_id', '\Equipment', 'equipment_id', ['alias' => 'Equipment']);
        $this->belongsTo('specifications_specifications_id', '\Specifications', 'specifications_id', ['alias' => 'Specifications']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment_has_specifications';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasSpecifications[]|EquipmentHasSpecifications|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasSpecifications|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
