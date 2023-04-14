<?php

namespace Albucas\DiPhp\Tests\App;

use Albuca\DiPhp\App\Application;
use Albuca\DiPhp\App\Exception\NotFoundException;
use Albuca\DiPhp\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ApplicationUTest extends TestCase
{
    /** @var ContainerInterface&MockObject */
    private ContainerInterface $mockedContainer;

    /** @var User&MockObject */
    private User $mockedUser;

    public function setUp(): void
    {
        $this->mockedContainer = $this->createMock(ContainerInterface::class);
        $this->mockedUser = $this->createMock(User::class);
    }

    public function testRunSuccess(): void
    {
        $expectedUserId = 10;

        $this->mockedUser
            ->expects($this->once())
            ->method('saveUser')
            ->willReturn($expectedUserId);

        $this->mockedContainer
            ->expects($this->once())
            ->method('get')
            ->with(User::class)
            ->willReturn($this->mockedUser);

        $application = $this->createInstance();

        $this->expectOutputString("\nThe created user is the ID #{$expectedUserId}\n");

        $application->run();
    }


    public function testRunException(): void
    {
        $this->mockedContainer
            ->expects($this->once())
            ->method('get')
            ->with(User::class)
            ->willThrowException(new NotFoundException('Could not resolve dependencies'));

        $application = $this->createInstance();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Could not resolve dependencies');

        $application->run();
    }

    private function createInstance(): Application
    {
        return new Application($this->mockedContainer);
    }
}