<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

// class User extends \Phalcon\Mvc\Model
class User extends \Phalcon\Mvc\MongoCollection
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="user_id", type="integer", length=11, nullable=false)
     */
    public $_id;

    /**
     *
     * @var string
     * @Column(column="email", type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     *
     * @var string
     * @Column(column="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     *
     * @var string
     * @Column(column="first_name", type="string", length=45, nullable=false)
     */
    protected $first_name;

    /**
     *
     * @var string
     * @Column(column="second_name", type="string", length=45, nullable=false)
     */
    protected $second_name;

    /**
     *
     * @var string
     * @Column(column="third_name", type="string", length=45, nullable=true)
     */
    protected $third_name;

    /**
     *
     * @var string
     * @Column(column="title", type="string", length=45, nullable=true)
     */
    protected $title;

    /**
     *
     * @var string
     * @Column(column="role", type="string", nullable=false)
     */
    protected $role;

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Method to set the value of field first_name
     *
     * @param string $first_name
     * @return $this
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Method to set the value of field second_name
     *
     * @param string $second_name
     * @return $this
     */
    public function setSecondName($second_name)
    {
        $this->second_name = $second_name;

        return $this;
    }

    /**
     * Method to set the value of field third_name
     *
     * @param string $third_name
     * @return $this
     */
    public function setThirdName($third_name)
    {
        $this->third_name = $third_name;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field role
     *
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Returns the value of field second_name
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->second_name;
    }

    /**
     * Returns the value of field third_name
     *
     * @return string
     */
    public function getThirdName()
    {
        return $this->third_name;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
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
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Пожалуйста, введите корректный адрес электронной почты',
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
    //     $this->setSchema("bachelor");
    //     $this->setSource("user");
    // }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
