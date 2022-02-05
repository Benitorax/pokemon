<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;
use App\Domain\Helper\EntityManagerInterface;

class PokemonHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addPokemon(Pokemon $pokemon, User $user): void
    {
        $user->addPokemon($pokemon);
        $this->entityManager->persist($pokemon);
        $this->entityManager->flush();
    }
}
