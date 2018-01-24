<?php

return [
/* 
 * Application configurations
 * these are general, application-wide
 * configuration values
 */

    'app' => [
        'gcProb' => getEnv('APP_SESSION_GARBAGECOLLECTION', 1),
    ],
];
