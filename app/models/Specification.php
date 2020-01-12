<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class Specification extends \Phalcon\Mvc\MongoCollection
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="specification_id", type="integer", length=11, nullable=false)
     */
    public $_id;

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
     * Method to set the value of field specification_id
     *
     * @param integer $specification_id
     * @return $this
     */
    public function setSpecificationId($specification_id)
    {
        $this->_id = $specification_id;

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
     * Returns the value of field specification_id
     *
     * @return integer
     */
    public function getSpecificationId()
    {
        return $this->_id;
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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'name',
            new PresenceOf(['message' => 'Имя обязательно к заполнению'])
        );
        $validator->add(
            'expected_max_value',
            new PresenceOf(['message' => 'Ожидаемое значение обязательно к заполнению'])
        );

        return $this->validate($validator);
    }


    /**
     * Initialize method for model.
     */
    // public function initialize()
    // {
    //     // Для поддержки PresenceOf валидации
    //     $this->setup(
    //         [ 'notNullValidations' => false ]
    //     );

    //     $this->setSchema("bachelor");
    //     $this->setSource("specification");
    //     $this->hasMany('specification_id', 'EquipmentHasSpecification', 'specification_specification_id', ['alias' => 'EquipmentHasSpecification']);
    //     $this->hasManyToMany(
    //         'specification_id',
    //         'EquipmentHasSpecification',
    //         'specification_specification_id', 'equipment_equipment_id',
    //         'Equipment',
    //         'equipment_id',
    //         ['alias' => 'Equipment']
    //     );
    // }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'specification';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Specification[]|Specification|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Specification|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
