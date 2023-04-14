<?php

namespace Albuca\DiPhp\Domain;

readonly class User
{
    public function __construct(private RepositoryInterface $repository)
    {
        //
    }

    /**
     * Must save user into $repository and return the ID from
     * created user.
     *
     * @return int
     */
    public function saveUser(): int
    {
        return $this->repository->save();
    }
}