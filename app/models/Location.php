<?php

class Location extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="location_id", type="integer", length=11, nullable=false)
     */
    public $location_id;

    /**
     *
     * @var string
     * @Column(column="campus", type="string", length=50, nullable=false)
     */
    public $campus;

    /**
     *
     * @var string
     * @Column(column="auditory", type="string", length=50, nullable=false)
     */
    public $auditory;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("location");
        $this->hasMany('location_id', 'MaterialValue', 'location_location_id', ['alias' => 'MaterialValue']);
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
        return Location::find([
            'conditions' => '',
            'columns' => ['location_id', "CONCAT(campus, '-', auditory) as fullname"]
        ]);
    }

    /**
     * Returns location full name
     *
     * @param location_id $location_id
     * @return string
     */
    public static function getLocationFullName($location_id = null)
    {
        $test = Location::findFirst([
            $location_id,
            'columns' => ["CONCAT(campus, '-', auditory) as fullname"]
        ]);
        return $test->fullname;
    }

}
