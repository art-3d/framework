<?php

return [
    'mode' => 'dev',
    'routes' => include('routes.php'),
    'main_layout' => __DIR__ . '/../../src/Blog/views/layout.html.php',
    'error_500'  => __DIR__ . '/../../src/Blog/views/500.html.php',
    'pdo' => [
        'dsn' => 'mysql:host=db;port=3306;dbname=education;charset=UTF8',
        'user' => 'root',
        'password' => 'root'
    ],
    'security' => [
        'user_class'  => 'Blog\\Model\\User',
        'login_route' => 'login'
    ],
    'commands' => include('commands.php'),
    'services' => include('services.php'),
];
