<?php

namespace App\Tests\Domaine\Main;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Main\DTO\CreateUser;
use App\Domain\Main\Entity\Pokemon;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Service\User\UserHandler;

class UserHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    private UserHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new UserHandler($this->entityManager);
    }

    public function testCreateAndSave(): void
    {
        $dto = (new CreateUser())
            ->setEmail('example@mail.com')
            ->setUsername('username')
            ->setPassword('123456')
        ;

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
        ;
        $this->entityManager
            ->expects($this->once())
            ->method('flush')
        ;

        $user = $this->handler->createAndSave($dto);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('example@mail.com', $user->getEmail());
        $this->assertSame('username', $user->getUsername());
        $this->assertSame('123456', $user->getPassword());
    }

    public function testAddPokemon(): void
    {
        $pokemon = new Pokemon();
        $user = new User();
        $this->entityManager
            ->expects($this->once())
            ->method('persist')
        ;
        $this->entityManager
            ->expects($this->once())
            ->method('flush')
        ;
        $this->handler->addPokemon($pokemon, $user);
        $this->assertContains($pokemon, $user->getPokemons());
    }

    public function testRemovePokemon(): void
    {
        $pokemon = new Pokemon();
        $user = new User();
        $user->addPokemon($pokemon);
        $this->entityManager
            ->expects($this->once())
            ->method('flush')
        ;
        $this->handler->removePokemon($pokemon, $user);
        $this->assertNotContains($pokemon, $user->getPokemons());
    }
}
