<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class License extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="license_id", type="integer", length=11, nullable=false)
     */
    protected $license_id;

    /**
     *
     * @var string
     * @Column(column="po_name", type="string", length=255, nullable=false)
     */
    protected $po_name;

    /**
     *
     * @var string
     * @Column(column="po_version", type="string", length=255, nullable=false)
     */
    protected $po_version;

    /**
     *
     * @var string
     * @Column(column="license_number", type="string", length=255, nullable=false)
     */
    protected $license_number;

    /**
     *
     * @var string
     * @Column(column="end_date", type="string", nullable=false)
     */
    protected $end_date;

    /**
     * Method to set the value of field license_id
     *
     * @param integer $license_id
     * @return $this
     */
    public function setLicenseId($license_id)
    {
        $this->license_id = $license_id;

        return $this;
    }

    /**
     * Method to set the value of field po_name
     *
     * @param string $po_name
     * @return $this
     */
    public function setPoName($po_name)
    {
        $this->po_name = $po_name;

        return $this;
    }

    /**
     * Method to set the value of field po_version
     *
     * @param string $po_version
     * @return $this
     */
    public function setPoVersion($po_version)
    {
        $this->po_version = $po_version;

        return $this;
    }

    /**
     * Method to set the value of field license_number
     *
     * @param string $license_number
     * @return $this
     */
    public function setLicenseNumber($license_number)
    {
        $this->license_number = $license_number;

        return $this;
    }

    /**
     * Method to set the value of field end_date
     *
     * @param string $end_date
     * @return $this
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * Returns the value of field license_id
     *
     * @return integer
     */
    public function getLicenseId()
    {
        return $this->license_id;
    }

    /**
     * Returns the value of field po_name
     *
     * @return string
     */
    public function getPoName()
    {
        return $this->po_name;
    }

    /**
     * Returns the value of field po_version
     *
     * @return string
     */
    public function getPoVersion()
    {
        return $this->po_version;
    }

    /**
     * Returns the value of field license_number
     *
     * @return string
     */
    public function getLicenseNumber()
    {
        return $this->license_number;
    }

    /**
     * Returns the value of field end_date
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->end_date;
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
            'po_name',
            new PresenceOf(['message' => 'Название обязательно к заполнению'])
        );
        $validator->add(
            'po_version',
            new PresenceOf(['message' => 'Версия обязательна к заполнению'])
        );
        $validator->add(
            'license_number',
            new PresenceOf(['message' => 'Лицензионный номер обязателен к заполнению'])
        );
        $validator->add(
            'end_date',
            new PresenceOf(['message' => 'Дата обязательна к заполнению'])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        // Для поддержки PresenceOf валидации
        $this->setup(
            [ 'notNullValidations' => false ]
        );

        $this->setSchema("bachelor");
        $this->setSource("license");
        $this->hasMany('license_id', 'EquipmentHasLicense', 'license_license_id', ['alias' => 'EquipmentHasLicense']);
        $this->hasManyToMany(
            'license_id',
            'EquipmentHasLicense',
            'license_license_id', 'equipment_equipment_id',
            'Equipment',
            'equipment_id',
            ['alias' => 'Equipment']
        );
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

    /**
     * Called before save
     */
    public function beforeSave()
    {
        //Converting any date to sql format
        $this->end_date = date('Y-m-d', strtotime($this->end_date));
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

}
