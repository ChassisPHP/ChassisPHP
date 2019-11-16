<?php

/**
 * Configuration for mail
 *
 */
return [
    'host'           => getEnv('EMAIL_HOST'),
    'tls'            => getEnv('EMAIL_TLS'),
    'port'           => getEnv('EMAIL_PORT'),
    'username'       => getEnv('EMAIL_USERNAME'),
    'password'       => getEnv('EMAIL_PASSWORD'),
    'cc'             => getEnv('EMAIL_CC'),
    'supportAddress' => getenv('EMAIL_SUPPORT_ADRESS'),
];
