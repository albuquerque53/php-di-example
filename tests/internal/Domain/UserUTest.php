<?php

namespace Albucas\DiPhp\Tests\Domain;

use Albuca\DiPhp\Domain\RepositoryInterface;
use Albuca\DiPhp\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;

class UserUTest extends \PHPUnit\Framework\TestCase
{
    /** @var RepositoryInterface&MockObject */
    private RepositoryInterface $mockedRepository;

    public function setUp(): void
    {
        $this->mockedRepository = $this->createMock(RepositoryInterface::class);
    }

    public function testSaveUser(): void
    {
        $expectedUserId = 100;

        $this->mockedRepository
            ->expects($this->once())
            ->method('save')
            ->willReturn($expectedUserId);

        $user = $this->createInstance();
        $userId = $user->saveUser();

        $this->assertEquals($expectedUserId, $userId);
    }

    private function createInstance(): User
    {
        return new User($this->mockedRepository);
    }
}