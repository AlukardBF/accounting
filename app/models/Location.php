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
    protected $location_id;

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
        $this->location_id = $location_id;

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
        return $this->location_id;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("location");
        $this->hasMany('location_id', 'MaterialValue', 'location_location_id', ['alias' => 'MaterialValue']);
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

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'location';
    }

}
