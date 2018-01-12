<?php

namespace Database\entities;

//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="users",uniqueConstraints={@UniqueConstraint(name="unique_email", columns={"email"})})
*/
class User
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    **/
    protected $id;

    /**
    *  @ORM\Column(type="string", length=255)
    *  @Assert\NotBlank()
    **/
    protected $name;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    * @Assert\NotBlank()
    * @Assert\Email()
    **/
    protected $email;

    /**
    * @ORM\Column(type="string", length=64)
    **/
    protected $passwd;

    /**
    * @ORM\Column(type="integer")
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
