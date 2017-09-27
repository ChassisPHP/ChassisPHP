<?PHP

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
    ],
];
