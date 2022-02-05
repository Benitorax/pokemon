<?php

namespace App\Application;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokemon;
use App\Domain\Main\Service\User\PokemonHandler;

class PokemonManager
{
    private PokemonHandler $handler;

    public function __construct(PokemonHandler $handler)
    {
        $this->handler = $handler;
    }

    public function addPokemon(Pokemon $pokemon, User $user): void
    {
        $this->handler->addPokemon($pokemon, $user);
    }
}
