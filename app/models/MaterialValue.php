<?php

class MaterialValue extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="material_value_id", type="integer", length=11, nullable=false)
     */
    public $material_value_id;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=false)
     */
    public $type;

    /**
     *
     * @var string
     * @Column(column="inventory_num", type="string", length=20, nullable=false)
     */
    public $inventory_num;

    /**
     *
     * @var string
     * @Column(column="serial_num", type="string", length=20, nullable=true)
     */
    public $serial_num;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(column="description", type="string", nullable=true)
     */
    public $description;

    /**
     *
     * @var double
     * @Column(column="price", type="double", length=10, nullable=true)
     */
    public $price;

    /**
     *
     * @var integer
     * @Column(column="count", type="integer", length=10, nullable=false)
     */
    public $count;

    /**
     *
     * @var string
     * @Column(column="enter_date", type="string", nullable=false)
     */
    public $enter_date;

    /**
     *
     * @var string
     * @Column(column="exit_date", type="string", nullable=true)
     */
    public $exit_date;

    /**
     *
     * @var string
     * @Column(column="photo", type="string", length=255, nullable=true)
     */
    public $photo;

    /**
     *
     * @var integer
     * @Column(column="location_location_id", type="integer", length=11, nullable=false)
     */
    public $location_location_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("material_value");
        $this->hasMany('material_value_id', 'Equipment', 'material_value_material_value_id', ['alias' => 'Equipment']);
        $this->hasMany('material_value_id', 'Furniture', 'material_value_material_value_id', ['alias' => 'Furniture']);
        $this->belongsTo('location_location_id', '\Location', 'location_id', ['alias' => 'Location']);
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

}
