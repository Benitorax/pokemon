<?php

namespace App\Tests\Application;

use App\Domain\Main\Entity\User;
use App\Application\PokemonManager;
use App\Domain\Main\Entity\Pokemon;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Main\Service\User\PokemonHandler;
use PHPUnit\Framework\TestCase;

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

    public function testAddPokemon(): void
    {
        $pokemon = new Pokemon();
        $user = new User();
        $this->pokemonHandler
            ->expects($this->once())
            ->method('addPokemon')
            ->with($pokemon, $user)
        ;

        $this->manager->addPokemon($pokemon, $user);
    }
}
