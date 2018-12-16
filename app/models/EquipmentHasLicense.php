<?php

class EquipmentHasLicense extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="equipment_equipment_id", type="integer", length=11, nullable=false)
     */
    public $equipment_equipment_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="equipment_material_value_material_value_id", type="integer", length=11, nullable=false)
     */
    public $equipment_material_value_material_value_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="license_license_id", type="integer", length=11, nullable=false)
     */
    public $license_license_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("equipment_has_license");
        $this->belongsTo('equipment_equipment_id', '\Equipment', 'equipment_id', ['alias' => 'Equipment']);
        $this->belongsTo('license_license_id', '\License', 'license_id', ['alias' => 'License']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment_has_license';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasLicense[]|EquipmentHasLicense|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EquipmentHasLicense|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
