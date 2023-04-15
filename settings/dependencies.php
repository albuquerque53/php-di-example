<?php

use Albuca\DiPhp\Domain\User;
use Albuca\DiPhp\Infra\Database\Repository;
use Psr\Container\ContainerInterface;

return [
    User::class => function (ContainerInterface $container): User {
        $repository = $container->get(Repository::class);

        return new User($repository);
    }
];