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
        $this->entitymanager = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/entities"), $this->isDevMode);

        $conn = array(
                'driver' => 'pdo_sqlite',
                    'path' => __DIR__ . '/db.sqlite',
                );

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $config);
    }
}
