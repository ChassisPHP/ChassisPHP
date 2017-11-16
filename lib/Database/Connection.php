<?php

namespace Lib\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Lib\Framework\Config;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Connection
{
    public $entitymanager;
    private $isDevMode = true;
    private $config;

    public function __construct()
    {
        $this->config = new Config;
        //$connectionConfig = Setup::createAnnotationMetadataConfiguration(array(dirname(__FILE__, 3)."/Database/Entities"), $this->isDevMode);
        $driver = envar('DATABASE_DRIVER', 'pdo_mysql');
        $dbType = envar('DATABASE_TYPE', 'mysql');
        $path = dirname(__FILE__, 3) . "/" . $this->config[$dbType]['database'];
        $conn = array(
                'driver' => $driver,
                'path' => $path,
            );

        $connectionConfig = Setup::createConfiguration($this->isDevMode);
        $connectionDriver = new AnnotationDriver(new AnnotationReader(), dirname(__FILE__, 3)."/Database/Entities");
        
        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $connectionConfig->setMetadataDriverImpl($connectionDriver);

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $connectionConfig);
    }
}
