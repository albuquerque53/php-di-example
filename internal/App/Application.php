<?php

namespace Albuca\DiPhp\App;

use Albuca\DiPhp\Domain\User;
use Psr\Container\ContainerInterface;

readonly class Application
{
    public function __construct(private ContainerInterface $container)
    {
        //
    }

    /**
     * Executes the application logic.
     *
     * @return void
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(): void
    {
        /** @var User $user */
        $user = $this->container->get(User::class);

        $userId = $user->saveUser();

        echo PHP_EOL . "The created user is the ID #{$userId}" . PHP_EOL;
    }
}