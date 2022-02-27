<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Main\Entity\Pokemon;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Helper\PokemonApiInterface;

class PokemonHandler
{
    private EntityManagerInterface $entityManager;

    private PokemonApiInterface $pokemonApi;

    public function __construct(
        EntityManagerInterface $entityManager,
        PokemonApiInterface $pokemonApi
    ) {
        $this->entityManager = $entityManager;
        $this->pokemonApi = $pokemonApi;
    }

    public function fullRestore(Pokemon $pokemon): void
    {
        $apiId = $pokemon->getApiId();
        $fullHP = $this->pokemonApi->getPokemonFullHP($apiId);
        $pokemon->setHp($fullHP);
        $pokemon->setIsKO(false);
        $this->entityManager->flush();
    }

    public function restoreHP(Pokemon $pokemon, int $HP): void
    {
        $pokemon->increaseHP($HP);
        $this->entityManager->flush();
    }
}
