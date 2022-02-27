<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;

/**
 * This Team class is used for tournament and PVP battle.
 */
class FightTeam implements TeamInterface
{
    use TeamTrait;

    private ?Pokemon $pokemon1 = null;

    private ?Pokemon $pokemon2 = null;

    private ?Pokemon $pokemon3 = null;

    public function __construct(User $trainer = null)
    {
        if (null !== $trainer) {
            $this->setTrainer($trainer);
        }
    }

    public function getPokemon1(): ?Pokemon
    {
        return $this->pokemon1;
    }

    public function setPokemon1(Pokemon $pokemon1): self
    {
        $this->pokemon1 = $pokemon1;

        return $this;
    }

    public function getPokemon2(): ?Pokemon
    {
        return $this->pokemon2;
    }

    public function setPokemon2(Pokemon $pokemon2): self
    {
        $this->pokemon2 = $pokemon2;

        return $this;
    }

    public function getPokemon3(): ?Pokemon
    {
        return $this->pokemon3;
    }

    public function setPokemon3(Pokemon $pokemon3): self
    {
        $this->pokemon3 = $pokemon3;

        return $this;
    }
}
