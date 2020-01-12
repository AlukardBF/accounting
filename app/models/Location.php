<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\PresenceOf;
use MongoDB\BSON\ObjectId;

// class Location extends \Phalcon\Mvc\Model
class Location extends \Phalcon\Mvc\MongoCollection
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="location_id", type="integer", length=11, nullable=false)
     */
    public $_id;

    /**
     *
     * @var string
     * @Column(column="campus", type="string", length=50, nullable=false)
     */
    protected $campus;

    /**
     *
     * @var string
     * @Column(column="auditory", type="string", length=50, nullable=false)
     */
    protected $auditory;

    /**
     * Method to set the value of field location_id
     *
     * @param integer $location_id
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->_id = $location_id;

        return $this;
    }

    /**
     * Method to set the value of field campus
     *
     * @param string $campus
     * @return $this
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * Method to set the value of field auditory
     *
     * @param string $auditory
     * @return $this
     */
    public function setAuditory($auditory)
    {
        $this->auditory = $auditory;

        return $this;
    }

    /**
     * Returns the value of field location_id
     *
     * @return integer
     */
    public function getLocationId()
    {
        return $this->_id;
    }

    /**
     * Returns the value of field campus
     *
     * @return string
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * Returns the value of field auditory
     *
     * @return string
     */
    public function getAuditory()
    {
        return $this->auditory;
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
            'campus',
            new PresenceOf(['message' => 'Корпус обязателен к заполнению'])
        );
        $validator->add(
            'auditory',
            new PresenceOf(['message' => 'Аудитория обязательна к заполнению'])
        );

        $validator->add(
            [
                'campus',
                'auditory'
            ],
            new UniquenessValidator(
                [
                    'model'   => $this,
                    'message' => 'Местоположение должно быть уникальным',
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
    //     $this->setSource("location");
    //     $this->hasMany('location_id', 'MaterialValue', 'location_location_id', ['alias' => 'MaterialValue']);
    // }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Location[]|Location|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Location|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns all location concatenated by name
     *
     * @param mixed $parameters
     * @return Location[]|Location|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function getAllByFullname($parameters = null)
    {
        $locations = Location::aggregate([[
            "\$project" => [
                "fullname" => [
                    "\$concat" => [
                        "\$campus", "-", "\$auditory"
                    ]
                ]
            ]
        ]]);
        $result = [];
        foreach($locations as $one) {
            $temp = [];
            $temp[strval($one["_id"])] = $one["fullname"];
            $result[] = $temp;
        }
        return $result;
    }

    /**
     * Returns location full name
     *
     * @param location_id $location_id
     * @return string
     */
    public static function getLocationFullName($location_id = null)
    {
        $location = Location::findById($location_id);
        return $location->getCampus() . '-' . $location->getAuditory();
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'location';
    }

    // protected function toArray()
    // {
    //     return $this->getArray($this->object);
    // }

    protected static function getArray($obj)
    {
        $array  = array(); // noisy $array does not exist
        $arrObj = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($arrObj as $key => $val) {
                $val = (is_array($val) || is_object($val)) ? Location::getArray($val) : $val;
                $array[$key] = $val;
        }
        return $array;
    }

}
