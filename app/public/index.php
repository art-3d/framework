<?php

define('_ROOT', dirname(dirname(__FILE__)));

require_once(_ROOT . '/framework/Loader.php');

Loader::addNamespacePath('Blog\\', __DIR__ . '/../src/Blog');
Loader::addNamespacePath('CMS\\', __DIR__ . '/../src/CMS');

$config = require_once(_ROOT . '/app/config/config.php');

$app = new Framework\Application\WebApplication(
    $config,
    new Framework\DI\Container($config['services'])
);

$app->run();
