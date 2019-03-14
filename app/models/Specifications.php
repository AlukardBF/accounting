<?php

class Specifications extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="specifications_id", type="integer", length=11, nullable=false)
     */
    protected $specifications_id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(column="expected_max_value", type="string", nullable=false)
     */
    protected $expected_max_value;

    /**
     * Method to set the value of field specifications_id
     *
     * @param integer $specifications_id
     * @return $this
     */
    public function setSpecificationsId($specifications_id)
    {
        $this->specifications_id = $specifications_id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field expected_max_value
     *
     * @param string $expected_max_value
     * @return $this
     */
    public function setExpectedMaxValue($expected_max_value)
    {
        $this->expected_max_value = $expected_max_value;

        return $this;
    }

    /**
     * Returns the value of field specifications_id
     *
     * @return integer
     */
    public function getSpecificationsId()
    {
        return $this->specifications_id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field expected_max_value
     *
     * @return string
     */
    public function getExpectedMaxValue()
    {
        return $this->expected_max_value;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("specifications");
        $this->hasMany('specifications_id', 'EquipmentHasSpecifications', 'specifications_specifications_id', ['alias' => 'EquipmentHasSpecifications']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'specifications';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Specifications[]|Specifications|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Specifications|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
