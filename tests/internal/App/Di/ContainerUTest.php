<?php

namespace internal\App\Di;

use Albuca\DiPhp\App\Di\Container;
use Albuca\DiPhp\App\Exception\ContainerException;
use Albuca\DiPhp\App\Exception\NotFoundException;

class ContainerUTest extends \PHPUnit\Framework\TestCase
{
    private array $instances;

    public function testGetSuccess(): void
    {
        $expectedObject = 'successObject';

        $this->instances = [
            'successClass' => function () {
                return 'successObject';
            }
        ];

        $container = $this->createInstance();

        $object = $container->get('successClass');

        $this->assertEquals($expectedObject, $object);
    }


    public function testGetNotFoundException(): void
    {
        $this->instances = [];

        $container = $this->createInstance();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Could not find the definition for notExistingClass');

        $container->get('notExistingClass');
    }

    public function testGetContainerException(): void
    {
        $this->instances = [
            'successClass' => function () {
                throw new \Exception('Invalid credentials') ;
            }
        ];

        $container = $this->createInstance();


        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $container->get('successClass');
    }

    public function createInstance(): Container
    {
        return new Container($this->instances);
    }
}