<?php

namespace Lib\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Lib\Framework\ConfigManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Connection
{
    public $entitymanager;
    private $isDevMode = true;

    public function __construct()
    {
        $driver = envar('DATABASE_DRIVER', 'pdo_mysql');
        $dbType = envar('DATABASE_TYPE', 'mysql');
        switch ($dbType) {
            case "sqlite":
                $path = dirname(__FILE__, 3) . "/" . ConfigManager::get("database.connections.$dbType.database");
                $conn = array(
                        'driver' => $driver,
                        'path' => $path,
                        );
                break;
            case "mysql":
                $dbName = envar('DATABASE_NAME');
                $dbUser = envar('DATABASE_USER');
                $dbPasswd = envar('DATABASE_PASSWORD');
                $dbHost = envar('DATABASE_HOST');
                $conn = array(
                    'dbname' => $dbName,
                    'user' => $dbUser,
                    'password' => $dbPasswd,
                    'host' => $dbHost,
                    'driver' => 'pdo_mysql',
                    );
                break;
            default:
                echo('invalid database type');
        }

        $connectionConfig = Setup::createConfiguration($this->isDevMode);
        $connectionDriver = new AnnotationDriver(new AnnotationReader(), dirname(__FILE__, 3)."/Database/Entities");
        
        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $connectionConfig->setMetadataDriverImpl($connectionDriver);

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $connectionConfig);
    }
}
