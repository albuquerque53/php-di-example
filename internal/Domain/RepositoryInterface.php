<?php

namespace Albuca\DiPhp\Domain;
interface RepositoryInterface
{
    /**
     * Must save into external repository
     *
     * @return int
     */
    public function save(): int;
}