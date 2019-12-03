<?php

/**
 * This configuration allows to configure multiple files for different log level output.
 * Logging output is per default placed in the storage folder.
 *
 * Only a debug path needs to be specified.
 */
return [

    'folder' => 'logs',

    // Datetime format to generate new log files for arbitrary time periods
    'prefix' => [
        'format' => 'Y-m-d',
        'separator' => '_',
    ],

    // Where to persist logging output
    'output' => [
        'emergency' => 'emergency.log',
        'debug'     => 'debug.log',
        'error'     => 'error.log',
        'info'      => 'info.log',
    ],
];
