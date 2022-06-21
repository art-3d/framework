<?php

require_once(__DIR__ . '/../framework/Loader.php');

Loader::addNamespacePath('Blog\\', __DIR__ . '/../src/Blog');
Loader::addNamespacePath('CMS\\', __DIR__ . '/../src/CMS');

$app = new Framework\Application\WebApplication(__DIR__ . '/../app/config/config.php');

$app->run();
