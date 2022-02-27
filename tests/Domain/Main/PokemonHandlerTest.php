<?php

namespace App\Tests\Domaine\Main;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\Pokemon;
use App\Domain\Helper\PokemonApiInterface;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Service\User\PokemonHandler;

class PokemonHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    /** @var MockObject&PokemonApiInterface */
    private $pokemonApi;

    private PokemonHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->pokemonApi = $this->createMock(PokemonApiInterface::class);
        $this->handler = new PokemonHandler($this->entityManager, $this->pokemonApi);
    }

    public function testFullRestore(): void
    {
        $this->entityManager->expects($this->once())->method('flush');
        $pokemon = new Pokemon();
        $this->handler->fullRestore($pokemon);
        $this->assertFalse($pokemon->getIsKO());
    }

    public function testRestoreHP(): void
    {
        $this->entityManager->expects($this->once())->method('flush');
        $pokemon = new Pokemon();
        $pokemon->setHP(50);
        $this->handler->restoreHP($pokemon, 150);
        $this->assertSame(200, $pokemon->getHP());
    }
}
