<?php

use Albuca\DiPhp\Domain\User;
use Albuca\DiPhp\Infra\Database\Repository;

return [
    User::class => function (): User {
        $repository = new Repository();

        return new User($repository);
    }
];