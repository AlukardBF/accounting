<?php

class Furniture extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="furniture_id", type="integer", length=11, nullable=false)
     */
    protected $furniture_id;

    /**
     *
     * @var string
     * @Column(column="specification", type="string", nullable=false)
     */
    protected $specification;

    /**
     * Method to set the value of field furniture_id
     *
     * @param integer $furniture_id
     * @return $this
     */
    public function setFurnitureId($furniture_id)
    {
        $this->furniture_id = $furniture_id;

        return $this;
    }

    /**
     * Method to set the value of field specification
     *
     * @param string $specification
     * @return $this
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * Returns the value of field furniture_id
     *
     * @return integer
     */
    public function getFurnitureId()
    {
        return $this->furniture_id;
    }

    /**
     * Returns the value of field specification
     *
     * @return string
     */
    public function getSpecification()
    {
        return $this->specification;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("furniture");
        $this->belongsTo('material_value_material_value_id', '\MaterialValue', 'material_value_id', ['alias' => 'MaterialValue']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Furniture[]|Furniture|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Furniture|\Phalcon\Mvc\Model\ResultInterface
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
        return 'furniture';
    }

}
