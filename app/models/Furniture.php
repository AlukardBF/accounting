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
     * @Column(column="specifications", type="string", nullable=false)
     */
    protected $specifications;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="material_value_material_value_id", type="integer", length=11, nullable=false)
     */
    protected $material_value_material_value_id;

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
     * Method to set the value of field specifications
     *
     * @param string $specifications
     * @return $this
     */
    public function setSpecifications($specifications)
    {
        $this->specifications = $specifications;

        return $this;
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
     * Returns the value of field furniture_id
     *
     * @return integer
     */
    public function getFurnitureId()
    {
        return $this->furniture_id;
    }

    /**
     * Returns the value of field specifications
     *
     * @return string
     */
    public function getSpecifications()
    {
        return $this->specifications;
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
