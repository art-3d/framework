<?php

declare(strict_types=1);

namespace Framework\Application;

use Framework\DI\Container;

final class ConsoleApplication extends Application
{
    public function __construct(
		private Container $container,
        private array $arguments,
	) {
		$container->add(self::class, $this);
	}

    public function run(): void
    {
    }
}
