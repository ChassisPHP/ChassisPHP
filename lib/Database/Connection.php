<?php

namespace Lib\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Lib\Framework\Config;

class Connection
{
    public $entitymanager;
    private $isDevMode = true;
    private $config;

    public function __construct()
    {
        $this->config = new Config;
        $connectionConfig = Setup::createAnnotationMetadataConfiguration(array(dirname(__FILE__, 3)."/Database/Entities"), $this->isDevMode);
        $driver = envar('DATABASE_DRIVER', 'pdo_mysql');
        $dbType = envar('DATABASE_TYPE', 'mysql');
        $path = dirname(__FILE__, 3) . "/" . $this->config[$dbType]['database'];
        $conn = array(
                'driver' => $driver,
                'path' => $path,
            );

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $connectionConfig);
    }
}
