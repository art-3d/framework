<?php

return [
    'home'           => [
        'pattern'    => '/',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'index'
    ],
    'testredirect'   => [
        'pattern'    => '/test_redirect',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'redirect',
    ],
    'test_json' => [
        'pattern'    => '/test_json',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'getJson',
    ],
    'registration'         => [
        'pattern'    => '/register',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'register'
    ],
    'login'          => [
        'pattern'    => '/login',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'login'
    ],
    'logout'         => [
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'logout'
    ],
    'update_profile' => [
        'pattern'       => '/profile',
        'controller'    => 'CMS\\Controller\\ProfileController',
        'action'        => 'update',
        '_requirements' => [
            '_method' => 'POST'
        ],
    ],
    'profile'        => [
        'pattern'    => '/profile',
        'controller' => 'CMS\\Controller\\ProfileController',
        'action'     => 'get'
    ],
    'add_post'       => [
        'pattern'    => '/posts/add',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'add',
        'security'   => ['ROLE_USER'],
    ],
    'show_post'      => [
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\Controller\\PostController',
        'action'        => 'show',
        '_requirements' => [
            'id' => '\d+'
        ],
    ],
    'edit_post'      => [
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\Controller\\BlogController',
        'action'        => 'edit',
        '_requirements' => [
            'id'      => '\d+',
            '_method' => 'POST'
        ],
    ],
];
