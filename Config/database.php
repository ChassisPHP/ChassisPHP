<?php

return [

    /*
     * Database connections
     * Currently only SQLite is set up
     * others to come soon
    */
   
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => getenv('DATABASE_PATH'),
        ],
        'mysql'  => [
            'driver' => 'pdo_mysql',
            'user' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD'),
            'host' => getenv('DATABASE_HOST'),
            'dbname' => getenv('DATABASE_NAME'),
        ],
    ],
];
