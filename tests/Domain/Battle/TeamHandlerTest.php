<?php

namespace App\Tests\Domain\Battle;

use App\Domain\Battle\Entity\AdventureTeam;
use App\Domain\Battle\Entity\FightTeam;
use App\Domain\Battle\Service\BattleType;
use PHPUnit\Framework\TestCase;
use App\Domain\Battle\Service\TeamHandler;
use App\Domain\Helper\PokemonApiInterface;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Entity\Habitat;

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

    public function testCreateNonPlayerTeam(): void
    {
        // test for adventure team
        $team = $this->handler->createNonPlayerTeam(BattleType::ADVENTURE, new Habitat());
        $this->assertInstanceOf(AdventureTeam::class, $team);

        // test for tournament team
        $team = $this->handler->createNonPlayerTeam(BattleType::TOURNAMENT, new Habitat());
        $this->assertInstanceOf(FightTeam::class, $team);

        // test exception
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage(
            sprintf(
                '$type should be value of BattleType::ADVENTURE or BattleType::TOURNAMENT, %s given',
                BattleType::PVP
            )
        );
        $this->handler->createNonPlayerTeam(BattleType::PVP, new Habitat());
    }
}
