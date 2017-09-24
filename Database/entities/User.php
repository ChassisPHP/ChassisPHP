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
    
    public function getUserName()
    {
        return $this->name;
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
