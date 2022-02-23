<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;
use App\Domain\Main\Entity\IdentifierTrait;

trait TeamTrait
{
    use IdentifierTrait;

    private User $trainer;

    /**
     * The current fighter.
     */
    private Pokemon $fighter;

    public function getTrainer(): User
    {
        return $this->trainer;
    }

    public function setTrainer(User $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getFighter(): Pokemon
    {
        return $this->fighter;
    }


    public function setFighter(Pokemon $fighter): self
    {
        $this->fighter = $fighter;

        return $this;
    }
}
