<?php

namespace Database\entities;

/**
 * @Entity @Table(name="users")
 * */
class User
{
    /**
    * @Id
    * @Column(type="integer")
    * @GeneratedValue
    **/
    protected $id;

    /**
    *  @Column(type="string", length=255)
    *  @Assert\NotBlank()
    **/
    protected $name;

    /**
    *  @Column(type="string", length=255, unique=true)
    *  @Assert\NotBlank()
    **/
    protected $userName;

    /**
    * @Column(type="string", length=255, unique=true)
    * @Assert\NotBlank()
    * @Assert\Email()
    **/
    protected $email;

    /**
    * @Column(type="string", length=64)
    **/
    protected $passwd;

    /**
    * @Column(type="integer")
    **/
    protected $userLevel;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getPasswd()
    {
        return $this->passwd;
    }

    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    }
    
    public function getUserLevel()
    {
        return $this->userLevel;
    }

    public function setUserLevel($userLevel)
    {
        $this->userLevel = $userLevel;
    }
}
