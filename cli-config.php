<?php

$connection = new \Lib\Database\Connection;
$entityManager = $connection->entityManager;

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
