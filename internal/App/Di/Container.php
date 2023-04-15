<?php

namespace Albuca\DiPhp\App\Di;

use Albuca\DiPhp\App\Exception\ContainerException;
use Albuca\DiPhp\App\Exception\NotFoundException;

readonly class Container implements \Psr\Container\ContainerInterface
{
    public function __construct(private array $instances = [])
    {
        //
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $class Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for **this** identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get(string $class): object
    {
        if ($this->has($class)) {
            return $this->tryToResolveWithDefinition($class);
        }

        try {
            $instance = $this->tryToResolveWithoutDefinition($class);
        } catch (\Throwable $throwable) {
            throw new NotFoundException(class: $class, previous: $throwable);
        }

        return $instance;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $class Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $class): bool
    {
        $definedClasses = array_keys($this->instances);

        return in_array($class, $definedClasses);
    }

    /**
     * Try to return an object of a deined $class using $this->instances.
     *
     * @param string $class
     * @return mixed
     * @throws ContainerException
     */
    public function tryToResolveWithDefinition(string $class): object
    {
        try {
            return $this->instances[$class]($this);
        } catch (\Throwable $throwable) {
            throw new ContainerException(message: $throwable->getMessage(), code: 500, previous: $throwable);
        }
    }

    /**
     * Try to return an object of not defined $class resolving the
     * recursive dependencies.
     *
     * @param string $class
     * @return object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    private function tryToResolveWithoutDefinition(string $class): object
    {
        $reflection = new \ReflectionClass($class);

        $classConstructor = $reflection->getConstructor();

        if (!$classConstructor) {
            return new $class;
        }

        $dependencies = $classConstructor->getParameters();
        $resolvedDependencies = [];

        foreach ($dependencies as $dependency) {
            $toInstantiate = $dependency->getType();

            $resolvedDependencies[] = $this->get($toInstantiate->getName());
        }

        return $reflection->newInstanceArgs($resolvedDependencies);
    }
}