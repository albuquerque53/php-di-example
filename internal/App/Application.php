<?php

namespace Albuca\DiPhp\App;

use Albuca\DiPhp\App\Di\Container;
use Albuca\DiPhp\Domain\User;

readonly class Application
{
    public function __construct(private Container $container)
    {
        //
    }

    /**
     * Executes the application logic.
     *
     * @return void
     *
     * @throws Exception\ContainerException
     * @throws Exception\NotFoundException
     */
    public function run(): void
    {
        /** @var User $user */
        $user = $this->container->get(User::class);

        $userId = $user->saveUser();

        echo PHP_EOL . "The created user is the ID #{$userId}" . PHP_EOL;
    }
}