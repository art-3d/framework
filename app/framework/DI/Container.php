<?php

namespace Framework\DI;

class Container
{
    protected array $bind = [];

    public function __construct(private array $services)
    {
    }

    /**
     *@ param string $abstract class ID, interface
     *@ param string $concrete class to bind
     */
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

    //It is equivalent to the previous make method
    public function build(string $abstract): object
    {
        $reflect = new \ReflectionClass($abstract);
        $constructor = $reflect->getConstructor();
        if (!is_null($constructor)) {
            $instances = $this->getParameters($constructor);

            return $reflect->newInstanceArgs($instances);
        }

        return $reflect->newInstance();
    }

    protected function getParameters(\ReflectionMethod $constructor)
    {
        $parameters = $constructor->getParameters();
        // var_dump($parameters);die;
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // echo $parameter->getType()->getName();die;
            // $class = $parameter->getType() && !$parameter->getType()->isBuiltin()
            //     ? new \ReflectionClass($parameter->getType()->getName())
            //     : null;
            // $dependencies[] = $this->make($class->name);

            if ($parameter->name === 'container') {
                $dependencies[] = $this;
                continue;
            }
            if (isset($this->services[$parameter->name]) && is_array($this->services[$parameter->name])) {
                $dependencies[] = $this->make(
                    $this->services[$parameter->name]['class']
                );
                continue;
            }

            $dependencies[] = isset($this->services[$parameter->name])
                ? $this->services[$parameter->name]
                : $this->make($parameter->getType()->getName());
        }

        return $dependencies;
    }
}
