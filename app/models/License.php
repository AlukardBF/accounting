<?php

class License extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="license_id", type="integer", length=11, nullable=false)
     */
    public $license_id;

    /**
     *
     * @var string
     * @Column(column="po_name", type="string", length=255, nullable=false)
     */
    public $po_name;

    /**
     *
     * @var string
     * @Column(column="po_version", type="string", length=255, nullable=false)
     */
    public $po_version;

    /**
     *
     * @var string
     * @Column(column="license_number", type="string", length=255, nullable=false)
     */
    public $license_number;

    /**
     *
     * @var string
     * @Column(column="end_date", type="string", nullable=false)
     */
    public $end_date;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("bachelor");
        $this->setSource("license");
        $this->hasMany('license_id', 'EquipmentHasLicense', 'license_license_id', ['alias' => 'EquipmentHasLicense']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'license';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return License[]|License|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return License|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
