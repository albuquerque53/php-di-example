<?php

namespace Albuca\DiPhp\Infra\Database;

use Albuca\DiPhp\Domain\RepositoryInterface;

class Repository implements RepositoryInterface
{
    /**
     * Must save into external repository
     *
     * @return int
     */
    public function save(): int
    {
        // save user...
        return 1;
    }
}