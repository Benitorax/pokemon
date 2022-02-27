<?php

namespace App\Domain\Battle\Service;

use App\Domain\Battle\Entity\Arena;
use App\Domain\Helper\PokemonApiInterface;
use App\Domain\Helper\EntityManagerInterface;

class ArenaHandler
{
    private EntityManagerInterface $entityManager;
    private PokemonApiInterface $pokemonApi;

    public function __construct(EntityManagerInterface $entityManager, PokemonApiInterface $pokemonApi)
    {
        $this->entityManager = $entityManager;
        $this->pokemonApi = $pokemonApi;
    }

    public function getRandomArena(): Arena
    {
        $arena = (new Arena())->setHabitat($this->pokemonApi->randomHabitat());
        $this->entityManager->persist($arena);
        $this->entityManager->flush();

        return $arena;
    }
}
