<?PHP

namespace Database\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="content",indexes={
*       @Index(name="publication_date", columns={"publicationDate"})},
*       uniqueConstraints={@UniqueConstraint(name="unique_position", columns={"position"})}
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
    protected $body;

    /**
     * @ORM\Column(type="string")
     */
    protected $author;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $publicationDate;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedDate;
    
    // Entity getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function getUpdatedDate()
    {
        return $this->updatedDate;
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

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }
}
