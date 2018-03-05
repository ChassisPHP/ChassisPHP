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
class Content
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
    protected $filename;

    /**
    * @ORM\Column(type="string")
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
    * Many Images have one Gallery.
    * @ORM\ManyToOne(targetEntity="gallery", inversedBy="images")
    * @ORM\JoinColumn(name="gallery", referencedColumnName="id")
    */
    protected $gallery;

    /**
    * @ORM\Column(type="datetime")
    */
    protected $publicationDate;
    
    /**
    * @ORM\Column(type="datetime")
    */
    protected $updated;

    /**
    * Many Imagess have One User.
    * @ORM\ManyToOne(targetEntity="User", inversedBy="imagess")
    * @ORM\JoinColumn(name="author", referencedColumnName="id")
    */
    private $author;
    
    // Entity getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function getCaption()
    {
        return $this->Caption;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getGallery()
    {
        return $this->gallery;
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
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

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

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;
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
