<?php

class EquipmentHasLicense extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="equipment_equipment_id", type="integer", length=11, nullable=false)
     */
    protected $equipment_equipment_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="license_license_id", type="integer", length=11, nullable=false)
     */
    protected $license_license_id;

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
     * Method to set the value of field license_license_id
     *
     * @param integer $license_license_id
     * @return $this
     */
    public function setLicenseLicenseId($license_license_id)
    {
        $this->license_license_id = $license_license_id;

        return $this;
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
     * Returns the value of field license_license_id
     *
     * @return integer
     */
    public function getLicenseLicenseId()
    {
        return $this->license_license_id;
    }

    /**
     * Method to set the value of field equipment_material_value_material_value_id
     *
     * @param integer $equipment_material_value_material_value_id
     * @return $this
     */
    public function setEquipmentMaterialValueMaterialValueId($equipment_material_value_material_value_id)
    {
        $this->equipment_material_value_material_value_id = $equipment_material_value_material_value_id;

        return $this;
    }

    /**
     * Returns the value of field equipment_material_value_material_value_id
     *
     * @return integer
     */
    public function getEquipmentMaterialValueMaterialValueId()
    {
        return $this->equipment_material_value_material_value_id;
    }

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

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipment_has_license';
    }

}
