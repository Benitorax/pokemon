<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Battle\Entity\Arena;
use App\Domain\Main\Entity\IdentifierTrait;

class Battle
{
    use IdentifierTrait;

    private string $type;

    private Arena $arena;

    private TeamInterface $team1;

    private TeamInterface $team2;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArena(): Arena
    {
        return $this->arena;
    }

    public function setArena(Arena $arena): self
    {
        $this->arena = $arena;

        return $this;
    }

    public function getTeam1(): TeamInterface
    {
        return $this->team1;
    }

    public function setTeam1(TeamInterface $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): TeamInterface
    {
        return $this->team2;
    }

    public function setTeam2(TeamInterface $team2): self
    {
        $this->team2 = $team2;

        return $this;
    }
}
