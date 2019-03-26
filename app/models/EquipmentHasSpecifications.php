<?php

class EquipmentHasSpecification extends \Phalcon\Mvc\Model
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
     * @Column(column="specification_specification_id", type="integer", length=11, nullable=false)
     */
    protected $specification_specification_id;

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
     * Method to set the value of field specification_specification_id
     *
     * @param integer $specification_specification_id
     * @return $this
     */
    public function setSpecificationSpecificationId($specification_specification_id)
    {
        $this->specification_specification_id = $specification_specification_id;

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
     * Returns the value of field specification_specification_id
     *
     * @return integer
     */
    public function getSpecificationSpecificationId()
    {
        return $this->specification_specification_id;
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
        $this->setSource("equipment_has_specification");
        $this->belongsTo('equipment_equipment_id', '\Equipment', 'equipment_id', ['alias' => 'Equipment']);
        $this->belongsTo('specification_specification_id', '\Specification', 'specification_id', ['alias' => 'Specification']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment_has_specification';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasSpecification[]|EquipmentHasSpecification|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasSpecification|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
