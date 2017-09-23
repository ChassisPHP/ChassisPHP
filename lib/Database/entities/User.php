<?PHP

namespace Lib\Database\entities\User;

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
    *  @Column(type="string", length=255, unique=true)
    *  @Assert\NotBlank()
    **/
    protected $userName;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    * @Assert\NotBlank()
    * @Assert\Email()
    **/
    private $email;

    /** @Column(type="integer") **/
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
    
    public function getPasswd()
    {
        return $this->name;
    }

    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    }
    
    public function getUserLevel()
    {
        return $this->name;
    }

    public function setUserLevel($userLevel)
    {
        $this->name = $userLevel;
    }
}
