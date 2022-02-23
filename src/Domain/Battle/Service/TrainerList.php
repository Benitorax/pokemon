<?php

namespace App\Domain\Battle\Service;

use App\Domain\Main\Entity\User;

class TrainerList
{
    /**
     * Return a random trainer.
     */
    public static function randomTrainer(): User
    {
        return new User();
    }
}
