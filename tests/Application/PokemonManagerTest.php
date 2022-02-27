<?php

namespace App\Tests\Application;

use PHPUnit\Framework\TestCase;
use App\Application\PokemonManager;
use App\Domain\Main\Entity\Pokemon;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Main\Service\User\PokemonHandler;

class PokemonManagerTest extends TestCase
{
    /** @var MockObject&PokemonHandler */
    private $pokemonHandler;

    private PokemonManager $manager;

    protected function setUp(): void
    {
        $this->pokemonHandler = $this->createMock(PokemonHandler::class);
        $this->manager = new PokemonManager($this->pokemonHandler);
    }

    public function testFullRestore(): void
    {
        $this->pokemonHandler->expects($this->once())->method('fullRestore');
        $this->manager->fullRestore(new Pokemon());
    }

    public function testRestoreHP(): void
    {
        $this->pokemonHandler->expects($this->once())->method('restoreHP');
        $this->manager->restoreHP(new Pokemon(), 150);
    }
}
