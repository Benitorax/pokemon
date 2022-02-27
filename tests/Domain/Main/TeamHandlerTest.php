<?php

namespace App\Tests\Domain\Main;

use App\Domain\Main\Entity\Pokemon;
use App\Domain\Battle\Entity\FightTeam;
use App\Domain\Battle\Service\TeamHandler;
use App\Domain\Helper\PokemonApiInterface;
use App\Domain\Battle\Entity\AdventureTeam;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TeamHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    /** @var MockObject&PokemonApiInterface */
    private $pokemonApi;

    private TeamHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->pokemonApi = $this->createMock(PokemonApiInterface::class);
        $this->handler = new TeamHandler($this->entityManager, $this->pokemonApi);
    }

    public function testAddPokemonInAdventure(): void
    {
        $pokemon = new Pokemon();
        $team = new AdventureTeam();
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->addPokemon($pokemon, $team);
        $this->assertSame($pokemon, $team->getFighter());
    }

    public function testAddPokemonsInFight(): void
    {
        $pokemon1 = new Pokemon();
        $pokemon2 = new Pokemon();
        $pokemon3 = new Pokemon();
        $team = new FightTeam();
        $this->entityManager->expects($this->exactly(3))->method('flush');
        $this->handler->addPokemon($pokemon1, $team);
        $this->handler->addPokemon($pokemon2, $team);
        $this->handler->addPokemon($pokemon3, $team);
        $this->assertSame($pokemon1, $team->getFighter());
    }
}
