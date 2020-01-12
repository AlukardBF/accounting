<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class Equipment extends \Phalcon\Mvc\MongoCollection
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="equipment_id", type="integer", length=11, nullable=false)
     */
    public $_id;

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
     * Method to set the value of field equipment_id
     *
     * @param integer $equipment_id
     * @return $this
     */
    public function setEquipmentId($equipment_id)
    {
        $this->_id = $equipment_id;

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
     * Returns the value of field equipment_id
     *
     * @return integer
     */
    public function getEquipmentId()
    {
        return $this->_id;
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
     * Returns the value of field material_value_material_value_id
     *
     * @return integer
     */
    public function getMaterialValueMaterialValueId()
    {
        return $this->material_value_material_value_id;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        // Русифицирование сообщений обязательных полей
        $validator->add(
            'type',
            new PresenceOf(['message' => 'Тип оргтехники обязателен к заполнению'])
        );
        $validator->add(
            'manufacturer',
            new PresenceOf(['message' => 'Производитель обязательно к заполнению'])
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
    //     $this->setSource("equipment");
    //     $this->hasMany('equipment_id', 'EquipmentHasLicense', 'equipment_equipment_id', ['alias' => 'EquipmentHasLicense']);
    //     $this->hasMany('equipment_id', 'EquipmentHasSpecification', 'equipment_equipment_id', ['alias' => 'EquipmentHasSpecification']);
    //     $this->belongsTo('material_value_material_value_id', '\MaterialValue', 'material_value_id', ['alias' => 'MaterialValue']);
    //     $this->hasManyToMany(
    //         'equipment_id',
    //         'EquipmentHasLicense',
    //         'equipment_equipment_id', 'license_license_id',
    //         'License',
    //         'license_id',
    //         ['alias' => 'License']
    //     );
    //     $this->hasManyToMany(
    //         'equipment_id',
    //         'EquipmentHasSpecification',
    //         'equipment_equipment_id', 'specification_specification_id',
    //         'Specification',
    //         'specification_id',
    //         ['alias' => 'Specification']
    //     );
    // }

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
