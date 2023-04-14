<?php

namespace internal\Infra\Database;

use Albuca\DiPhp\Infra\Database\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryUTest extends TestCase
{
    public function testSave(): void
    {
        $exepectedResult = 1;

        $repository = $this->createInstance();

        $result = $repository->save();

        $this->assertEquals($exepectedResult, $result);
    }

    private function createInstance(): Repository
    {
        return new Repository();
    }
}