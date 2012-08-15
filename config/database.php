<?php

/**
 * Basic config script for database settings.
 */
 
$db_settings = array(
    'database'  => 'db',
    'host'      => 'localhost',
    'user'      => 'user',
    'password'  => 'password',
);

include_once('local-' . basename(__FILE__));
