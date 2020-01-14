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
     *  @ORM\OneToMany(targetEntity="Image", mappedBy="album")
    **/
    protected $images;

    /**
    * Many Albums have One User.
    * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
    * @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
    */
    private $createdBy;

    /**
    * Many Albums have One updatedby User.
    * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
    * @ORM\JoinColumn(name="updatedBy", referencedColumnName="id")
    */
    private $updatedBy;

    /**
    * @ORM\Column(type="datetime")
    */
    protected $createdDate;

    /**
    * @ORM\Column(type="datetime")
    */
    protected $updated;

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

    public function getImages()
    {
        return $this->images;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    //setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function setUpdatedBy(User $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }


    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
}
