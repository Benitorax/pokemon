<?php

namespace App\Tests\Application;

use PHPUnit\Framework\TestCase;
use App\Application\UserManager;
use App\Domain\Main\Entity\User;
use App\Application\Mailer\Mailer;
use App\Domain\Main\DTO\CreateUser;
use App\Domain\Main\Entity\Pokemon;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Main\Service\User\UserHandler;

class UserManagerTest extends TestCase
{
    private UserManager $manager;

    /** @var MockObject&UserHandler */
    private $userHandler;

    /** @var MockObject&Mailer */
    private $mailer;

    protected function setUp(): void
    {
        $this->userHandler = $this->createMock(UserHandler::class);
        $this->mailer = $this->createMock(Mailer::class);
        $this->manager = new UserManager($this->userHandler, $this->mailer);
    }

    public function testSubscribeUser(): void
    {
        $dto = (new CreateUser())
            ->setEmail('example@mail.com')
            ->setUsername('username')
            ->setPassword('123456')
        ;
        $user = (new User())
            ->setEmail('example@mail.com')
            ->setUsername('username')
            ->setPassword('123456')
        ;
        $this->userHandler
            ->expects($this->once())
            ->method('createAndSave')
            ->with($dto)
            ->willReturn($user)
        ;
        $this->mailer
            ->expects($this->once())
            ->method('sendSubscription')
            ->with($user);
        ;
        $this->manager->subscribeUser($dto);
    }

    public function testAddPokemon(): void
    {
        $pokemon = new Pokemon();
        $user = new User();
        $this->userHandler
            ->expects($this->once())
            ->method('addPokemon')
            ->with($pokemon, $user)
        ;

        $this->manager->addPokemon($pokemon, $user);
    }

    public function testRemovePokemon(): void
    {
        $pokemon = new Pokemon();
        $user = new User();
        $this->userHandler
            ->expects($this->once())
            ->method('removePokemon')
            ->with($pokemon, $user)
        ;

        $this->manager->removePokemon($pokemon, $user);
    }
}
