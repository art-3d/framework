<?php

define('_ROOT', dirname(dirname(__FILE__)));

require_once(_ROOT . '/framework/Loader.php');

Loader::addNamespacePath('Blog\\', __DIR__ . '/../src/Blog');
Loader::addNamespacePath('CMS\\', __DIR__ . '/../src/CMS');

$services = require_once(_ROOT . '/app/config/services.php');

$app = new Framework\Application\WebApplication(
    new Framework\DI\Container($services)
);

$app->run();
