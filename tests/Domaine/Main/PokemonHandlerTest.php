<?php

namespace App\Tests\Domaine\Main;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Service\User\PokemonHandler;

class PokemonHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    private PokemonHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new PokemonHandler($this->entityManager);
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
    }
}
