<?php

namespace Framework\Application;

use Framework\DI\Service;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Router\Router;
use Framework\Security\Security;
use Framework\Session\Session;

abstract class Application
{
    public function __construct(public array $config)
    {
    }

    protected function run(): void
    {
		Service::set('application', $this);
		Service::set('router', new Router($this->config['routes']));
		Service::set('request', new Request());
		// Service::set('renderer', new Renderer());
		Service::set('session', new Session());
		Service::set('security', new Security());

		Service::set('pdo', new \PDO(
			$this->config['pdo']['dsn'],
			$this->config['pdo']['user'],
			$this->config['pdo']['password'],
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC],
		));
    }
}
