<?php

namespace App\Domain\Battle\Service;

use App\Domain\Main\Entity\User;
use App\Domain\Battle\Entity\Arena;
use App\Domain\Battle\Entity\Battle;
use App\Domain\Battle\Entity\FightTeam;
use App\Domain\Battle\Entity\AdventureTeam;
use App\Domain\Helper\EntityManagerInterface;

class BattleHandler
{
    private EntityManagerInterface $entityManager;
    private ArenaHandler $arenaHandler;
    private TeamHandler $teamHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArenaHandler $arenaHandler,
        TeamHandler $teamHandler
    ) {
        $this->entityManager = $entityManager;
        $this->arenaHandler = $arenaHandler;
        $this->teamHandler = $teamHandler;
    }

    public function createAdventureBattle(User $user, ?Arena $arena = null): Battle
    {
        $arena = $arena ?: $this->arenaHandler->getRandomArena();

        return (new Battle())
            ->setArena($arena)
            ->setType(BattleType::ADVENTURE)
            ->setTeam1(new AdventureTeam($user))
            ->setTeam2($this->teamHandler->createNonPlayerTeam(BattleType::ADVENTURE, $arena->getHabitat()))
        ;
    }

    public function createTournamentBattle(User $user, ?Arena $arena = null): Battle
    {
        $arena = $arena ?: $this->arenaHandler->getRandomArena();

        return (new Battle())
            ->setArena($arena)
            ->setType(BattleType::TOURNAMENT)
            ->setTeam1(new FightTeam($user))
            ->setTeam2($this->teamHandler->createNonPlayerTeam(BattleType::TOURNAMENT, $arena->getHabitat()))
        ;
    }

    public function createPVPBattle(User $user1, User $user2, ?Arena $arena = null): Battle
    {
        $arena = $arena ?: $this->arenaHandler->getRandomArena();

        return (new Battle())
            ->setArena($arena)
            ->setType(BattleType::PVP)
            ->setTeam1(new FightTeam($user1))
            ->setTeam2(new FightTeam($user2))
        ;
    }

    public function save(Battle $battle): void
    {
        $this->entityManager->persist($battle);
        $this->entityManager->flush();
    }
}
