<?php

namespace Database\Entities;

//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="users",uniqueConstraints={@UniqueConstraint(name="postion", columns={"position"})})
*/
class Gallery
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
    **/
    protected $position;
}
