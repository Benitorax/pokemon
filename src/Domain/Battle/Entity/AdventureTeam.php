<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Main\Entity\User;

class AdventureTeam implements TeamInterface
{
    use TeamTrait;

    public function __construct(User $trainer = null)
    {
        if (null !== $trainer) {
            $this->setTrainer($trainer);
        }
    }
}
