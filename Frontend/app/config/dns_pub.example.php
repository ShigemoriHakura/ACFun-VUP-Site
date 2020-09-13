<?php
return array(
    'database' => array(
        'host'     => '127.0.0.1',
        'database' => 'vup',
        'user'     => 'vup',
        'password' => 'password',
        'encode' => 'utf8',
        'port' => 3306,
    ),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'keep-alive' => true,
        //        'client' => 'predis', // predis
        //        'persistent' => true, // predis
    ),
);