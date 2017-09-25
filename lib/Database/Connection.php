<?PHP
namespace Lib\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Connection
{
    public $entitymanager;
    private $isDevMode = true;

    public function __construct()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(dirname(__FILE__, 3)."Database/entities"), $this->isDevMode);

        $conn = array(
                'driver' => 'pdo_sqlite',
                'path' => dirname(__FILE__, 3)."/Database/db.sqlite",
            );

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $config);
    }
}
