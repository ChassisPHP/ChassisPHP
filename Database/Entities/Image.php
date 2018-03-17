<?PHP

namespace Database\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="images",indexes={
*       @Index(name="publication_date", columns={"publicationDate"})},
*       uniqueConstraints={@UniqueConstraint(name="unique_position", columns={"position", "fileName"})}
*       )
*/
class Image
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    **/
    protected $id;
    
    /**
    * @ORM\Column(type="string", unique=true)
    */
    protected $title;

    /**
    * @ORM\Column(type="string", unique=true)
    */
    protected $position;

    /**
    * @ORM\Column(type="text")
    */
    protected $caption;

    /**
    * Many Images have one Album.
    * @ORM\ManyToOne(targetEntity="Album", inversedBy="Image")
    * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
    */
    protected $album;

    /**
    * @ORM\Column(type="datetime")
    */
    protected $publicationDate;
    
    /**
    * @ORM\Column(type="datetime")
    */
    protected $updated;

    /**
    * Many Images have One User.
    * @ORM\ManyToOne(targetEntity="User", inversedBy="imagess")
    * @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
    */
    private $createdBy;
    
    // Entity getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getCaption()
    {
        return $this->Caption;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getAlbum()
    {
        return $this->album;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    // Entity setters
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function setAlbum(Album $album)
    {
        $this->album = $album;
    }

    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    public function setUpdated($updated)
    {
        $this->updatedDate = $updated;
    }
}
