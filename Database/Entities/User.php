<?php

namespace Database\Entities;

//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="users",uniqueConstraints={@UniqueConstraint(name="unique_email", columns={"email"})})
*/
class User
{
    /**
    * @ORM\Id
    * @ORM\Column(name="id", type="integer")
    * @ORM\GeneratedValue(strategy="IDENTITY")
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
    * @ORM\Column(type="string", length=64)
    **/
    protected $forgotPasswd;

    /**
    * @ORM\Column(type="bigint")
    **/
    protected $expireForgotPasswd;

    /**
    * @ORM\Column(type="integer")
    **/
    protected $userLevel;

    /**
    * One User has Many Contents.
    * @ORM\OneToMany(targetEntity="Content", mappedBy="User")
    */
    protected $contents;

    /**
    * One User has Many Images.
    * @ORM\OneToMany(targetEntity="Image", mappedBy="User")
    */
    protected $images;

    public function __construct()
    {
        $this->contents = new ArrayCollection;
        $this->images = new ArrayCollection;
    }

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

    public function getForgotPasswd()
    {
        return $this->forgotPasswd;
    }

    public function setForgotPasswd($forgotPasswd)
    {
        $this->forgotPasswd = $forgotPasswd;
    }

    public function getExpireForgotPasswd()
    {
        return $this->expireForgotPasswd;
    }

    public function setExpireForgotPasswd($expireForgotPasswd)
    {
        $this->expireForgotPasswd = $expireForgotPasswd;
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
