<?php

namespace Database\Entities;

//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="albums",uniqueConstraints={@UniqueConstraint(name="name", columns={"name"})})
*/
class Album
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    **/
    protected $id;

    /**
    *  @ORM\Column(type="string", length=45)
    *  @Assert\NotBlank()
    **/
    protected $name;

    /**
    * @ORM\Column(type="text")
    * @Assert\NotBlank()
    **/
    protected $description;

    /**
    *  One album has many images
    *  @ORM\OneToMany(targetEntity="Image", mappedBy="Album")
    **/
    protected $images;

    /**
    * images that belong to an Album
    * in a colection
     */
    public function __construct()
    {
        $this->images = new ArrayCollection;
    }

    // Entity getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    //setters
    public function setName($name)
    {
        $this->userName = $name;
    }

    public function setDescription($description)
    {
        $this->userDescription = $description;
    }
}
