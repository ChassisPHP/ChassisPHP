<?php

$connection = new \Database\Connection;
$entityManager = $connection->entityManager;

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
