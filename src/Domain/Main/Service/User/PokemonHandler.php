<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Helper\EntityManagerInterface;

class PokemonHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
