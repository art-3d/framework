<?php

declare(strict_types=1);

namespace Framework\DI;

class Container
{
    protected array $bind = [];
    private array $container = [];

    public function __construct(private array $services) {}

    public function add(string $abstract, object $object): void
    {
        $this->container[$abstract] = $object;
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->bind[$abstract] = $this->build($concrete);
    }

    public function make(string $abstract)
    {
        if (!isset($this->bind[$abstract])) {
            $this->bind($abstract, $abstract);
        }

        return $this->bind[$abstract];
    }

    // It is equivalent to the previous make method
    public function build(string $abstract): object
    {
        if (isset($this->container[$abstract])) {
            return $this->container[$abstract];
        }

        $reflect = new \ReflectionClass($abstract);
        $constructor = $reflect->getConstructor();
        if (!is_null($constructor)) {
            $instances = $this->getParameters($constructor);

            return $this->container[$abstract] = $reflect->newInstanceArgs($instances);
        }

        return $this->container[$abstract] = $reflect->newInstance();
    }

    protected function getParameters(\ReflectionMethod $constructor): array
    {
        $parameters = $constructor->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            if ($parameter->getType()->getName() === self::class) {
                $dependencies[] = $this;

                continue;
            }

            $dependencies[] = isset($this->services[$parameter->name])
                ? $this->services[$parameter->name]
                : $this->build($parameter->getType()->getName());
        }

        return $dependencies;
    }
}
