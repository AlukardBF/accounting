<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\PresenceOf;

class MaterialValue extends \Phalcon\Mvc\MongoCollection
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="material_value_id", type="integer", length=11, nullable=false)
     */
    public $_id;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=false)
     */
    protected $type;

    /**
     *
     * @var string
     * @Column(column="inventory_num", type="string", length=20, nullable=false)
     */
    protected $inventory_num;

    /**
     *
     * @var string
     * @Column(column="serial_num", type="string", length=20, nullable=true)
     */
    protected $serial_num;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(column="description", type="string", nullable=true)
     */
    protected $description;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=10, nullable=true)
     */
    protected $price;

    /**
     *
     * @var integer
     * @Column(column="count", type="integer", length=10, nullable=false)
     */
    protected $count;

    /**
     *
     * @var string
     * @Column(column="enter_date", type="string", nullable=false)
     */
    protected $enter_date;

    /**
     *
     * @var string
     * @Column(column="exit_date", type="string", nullable=true)
     */
    protected $exit_date;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=255, nullable=true)
     */
    protected $photo;

    /**
     *
     * @var integer
     * @Column(column="location_location_id", type="integer", length=11, nullable=false)
     */
    protected $location_location_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="equipment_equipment_id", type="integer", length=11, nullable=true)
     */
    protected $equipment_equipment_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="furniture_furniture_id", type="integer", length=11, nullable=true)
     */
    protected $furniture_furniture_id;

    /**
     * Method to set the value of field material_value_id
     *
     * @param integer $material_value_id
     * @return $this
     */
    public function setMaterialValueId($material_value_id)
    {
        $this->_id = $material_value_id;

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
     * Method to set the value of field inventory_num
     *
     * @param string $inventory_num
     * @return $this
     */
    public function setInventoryNum($inventory_num)
    {
        $this->inventory_num = $inventory_num;

        return $this;
    }

    /**
     * Method to set the value of field serial_num
     *
     * @param string $serial_num
     * @return $this
     */
    public function setSerialNum($serial_num)
    {
        $this->serial_num = $serial_num;

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
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field price
     *
     * @param double $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Method to set the value of field count
     *
     * @param integer $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Method to set the value of field enter_date
     *
     * @param string $enter_date
     * @return $this
     */
    public function setEnterDate($enter_date)
    {
        $this->enter_date = $enter_date;

        return $this;
    }

    /**
     * Method to set the value of field exit_date
     *
     * @param string $exit_date
     * @return $this
     */
    public function setExitDate($exit_date)
    {
        $this->exit_date = $exit_date;

        return $this;
    }

    /**
     * Method to set the value of field photo
     *
     * @param string $photo
     * @return $this
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Method to set the value of field location_location_id
     *
     * @param integer $location_location_id
     * @return $this
     */
    public function setLocationLocationId($location_location_id)
    {
        $this->location_location_id = $location_location_id;

        return $this;
    }

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
     * Method to set the value of field furniture_furniture_id
     *
     * @param integer $furniture_furniture_id
     * @return $this
     */
    public function setFurnitureFurnitureId($furniture_furniture_id)
    {
        $this->furniture_furniture_id = $furniture_furniture_id;

        return $this;
    }

    /**
     * Returns the value of field material_value_id
     *
     * @return integer
     */
    public function getMaterialValueId()
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
     * Returns the value of field inventory_num
     *
     * @return string
     */
    public function getInventoryNum()
    {
        return $this->inventory_num;
    }

    /**
     * Returns the value of field serial_num
     *
     * @return string
     */
    public function getSerialNum()
    {
        return $this->serial_num;
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
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field price
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Returns the value of field count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Returns the value of field enter_date
     *
     * @return string
     */
    public function getEnterDate()
    {
        return $this->enter_date;
    }

    /**
     * Returns the value of field exit_date
     *
     * @return string
     */
    public function getExitDate()
    {
        return $this->exit_date;
    }

    /**
     * Returns the value of field photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Returns the value of field location_location_id
     *
     * @return integer
     */
    public function getLocationLocationId()
    {
        return $this->location_location_id;
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
     * Returns the value of field furniture_furniture_id
     *
     * @return integer
     */
    public function getFurnitureFurnitureId()
    {
        return $this->furniture_furniture_id;
    }

    public function getEquipment()
    {
        $id = $this->equipment_equipment_id;
        return Equipment::findById($id);
    }

    public function setEquipment($equipment)
    {
        $this->equipment_equipment_id = strval($equipment->getEquipmentId());
    }

    public function getFurniture()
    {
        $id = $this->furniture_furniture_id;
        return Furniture::findById($id);
    }

    public function setFurniture($furniture)
    {
        $this->furniture_furniture_id = strval($furniture->getFurnitureId());
    }

    public function getLocation()
    {
        $id = $this->location_location_id;
        return Location::findById($id);
    }

    public function setLocation($location)
    {
        $this->furniture_furniture_id = strval($location->getLocationId());
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
            'inventory_num',
            new PresenceOf(['message' => 'Инвентарный номер обязателен к заполнению'])
        );
        $validator->add(
            'name',
            new PresenceOf(['message' => 'Имя обязательно к заполнению'])
        );
        $validator->add(
            'count',
            new PresenceOf(['message' => 'Количество обязательно к заполнению'])
        );
        $validator->add(
            'enter_date',
            new PresenceOf(['message' => 'Дата ввода в эксплуатацию обязательна к заполнению'])
        );
        $validator->add(
            'location_location_id',
            new PresenceOf(['message' => 'Местоположение обязательно к заполнению'])
        );

        $validator->add(
            'inventory_num',
            new UniquenessValidator(
                [
                    'model'   => $this,
                    'message' => 'Инвентарный номер должен быть уникален',
                ]
            )
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
    //     $this->setSource("material_value");
    //     $this->belongsTo('equipment_equipment_id', '\Equipment', 'equipment_id', ['alias' => 'Equipment']);
    //     $this->belongsTo('furniture_furniture_id', '\Furniture', 'furniture_id', ['alias' => 'Furniture']);
    //     $this->belongsTo('location_location_id', '\Location', 'location_id', ['alias' => 'Location']);
    // }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MaterialValue[]|MaterialValue|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MaterialValue|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns all types with localized names
     *
     * @return string[]
     */
    public static function getAllTypes()
    {
        return [
            'assets' => 'Основные средства',
            'furniture' => 'Мебель',
            'equipment' => 'Оргтехника',
        ];
    }

    /**
     * Returns type localized name
     *
     * @return string
     */
    public function getTypeName()
    {
        switch ($this->type) {
            case 'assets':
                return 'Основные средства';
            case 'furniture':
                return 'Мебель';
            case 'equipment':
                return 'Оргтехника';
            default:
                return 'error_name';
        }
    }

    /**
     * Returns location localized name
     *
     * @return string
     */
    public function getLocationName()
    {
        return Location::getLocationFullName($this->location_location_id);
    }

    /**
     * Called before save
     */
    public function beforeSave()
    {
        //Converting any date to sql format
        $this->enter_date = date('Y-m-d', strtotime($this->enter_date));
        if ($this->exit_date == '')
            $this->exit_date = null;
        else
            $this->exit_date = date('Y-m-d', strtotime($this->exit_date));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'material_value';
    }

}
