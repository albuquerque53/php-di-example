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
    public function get(string $class): mixed
    {
        if (!$this->has($class)) {
            throw new NotFoundException('Could not find the definition for ' . $class, 500);
        }

        $instance = $this->instances[$class];

        try {
            return $instance();
        } catch (\Throwable $throwable) {
            throw new ContainerException($throwable->getMessage(), 500);
        }
    }


    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $class Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has(string $class): bool
    {
        $definedClasses = array_keys($this->instances);

        return in_array($class, $definedClasses);
    }
}