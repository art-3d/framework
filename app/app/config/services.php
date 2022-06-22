<?php

use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Router\Router;
use Framework\Security\Security;
use Framework\Session\Session;

return [
    'mainLayoutPath' => __DIR__ . '/../../src/Blog/views/layout.html.php',
    'router' => [
        'class' => Router::class,
        'arguments' => [
            'routesMap' => include('routes.php'),
        ],
    ],
    'request' => [
        'class' => Request::class,
    ],
    'renderer' => [
        'class' => Renderer::class,
        'arguments' => [
            'main_layout' => __DIR__ . '/../../src/Blog/views/layout.html.php',
        ],
    ],
    'session' => [
        'class' => Session::class,
    ],
    'security' => [
        'class' => Security::class,
    ],
    'pdo' => [
        'class' => \PDO::class,
        'config' => [

        ]
    ],
];
