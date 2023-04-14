<?php

use Albuca\DiPhp\Domain\User;
use Albuca\DiPhp\Infra\Database\Repository;
use Psr\Container\ContainerInterface;

return [
    Repository::class => function (ContainerInterface $container): Repository {
        return new Repository();
    },
    User::class => function (ContainerInterface $container): User {
        $repository = $container->get(Repository::class);

        return new User($repository);
    }
];