<?php

return [
    'mainLayoutPath' => __DIR__ . '/../../src/Blog/views/layout.html.php',
    'routeMap' => include('routes.php'),

    'pdoDsn' => 'mysql:host=db;port=3306;dbname=education;charset=UTF8',
    'user' => 'root',
    'password' => 'root',
    'pdoParams' => [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC],

    'commands' => include('commands.php'),

    'dbStructure' => file_get_contents(__DIR__ . '/../structure.sql'),
];
