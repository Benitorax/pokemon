<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Battle\Entity\Arena;

class Battle
{
    private Arena $arena;

    public function getArena(): Arena
    {
        return $this->arena;
    }

    public function setArena(Arena $arena): self
    {
        $this->arena = $arena;

        return $this;
    }
}
