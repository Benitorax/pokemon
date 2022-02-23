<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;

interface TeamInterface
{
    public function getTrainer(): User;

    public function setTrainer(User $trainer): self;

    public function getFighter(): Pokemon;

    public function setFighter(Pokemon $fighter): self;
}
