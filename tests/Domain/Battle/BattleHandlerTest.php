<?php

namespace App\Tests\Domain\Battle;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Battle\Entity\Arena;
use App\Domain\Main\Entity\Habitat;
use App\Domain\Battle\Entity\Battle;
use App\Domain\Battle\Service\TeamHandler;
use App\Domain\Battle\Service\ArenaHandler;
use App\Domain\Battle\Service\BattleHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;

class BattleHandlerTest extends TestCase
{
        /** @var MockObject&EntityManagerInterface */
        private $entityManager;

        /** @var MockObject&ArenaHandler */
        private $arenaHandler;

        /** @var MockObject&TeamHandler */
        private $teamHandler;

    private BattleHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->arenaHandler = $this->createMock(ArenaHandler::class);
        $this->teamHandler = $this->createMock(TeamHandler::class);
        $this->handler = new BattleHandler($this->entityManager, $this->arenaHandler, $this->teamHandler);
    }

    public function testCreateAdventureBattle(): void
    {
        // without arena
        $this->arenaHandler->expects($this->once())->method('getRandomArena');
        $battle = $this->handler->createAdventureBattle(new User());
        $this->assertInstanceOf(Battle::class, $battle);

        // with arena
        $this->arenaHandler->expects($this->exactly(0))->method('getRandomArena');
        $this->handler->createAdventureBattle(new User(), (new Arena())->setHabitat(new Habitat()));
    }

    public function testCreateTournamentBattle(): void
    {
        // without arena
        $this->arenaHandler->expects($this->once())->method('getRandomArena');
        $battle = $this->handler->createTournamentBattle(new User());
        $this->assertInstanceOf(Battle::class, $battle);

        // with arena
        $this->arenaHandler->expects($this->exactly(0))->method('getRandomArena');
        $this->handler->createTournamentBattle(new User(), (new Arena())->setHabitat(new Habitat()));
    }

    public function testcreatePVPBattle(): void
    {
        // without arena
        $this->arenaHandler->expects($this->once())->method('getRandomArena');
        $user1 = new User();
        $user2 = new User();
        $battle = $this->handler->createPVPBattle($user1, $user2);
        $this->assertInstanceOf(Battle::class, $battle);
        $this->assertSame($user1, $battle->getTeam1()->getTrainer());
        $this->assertSame($user2, $battle->getTeam2()->getTrainer());

        // with arena
        $this->arenaHandler->expects($this->exactly(0))->method('getRandomArena');
        $this->handler->createPVPBattle($user1, $user2, (new Arena())->setHabitat(new Habitat()));
    }

    public function testSave(): void
    {
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->save(new Battle());
    }
}
