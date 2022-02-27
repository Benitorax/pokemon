<?php

namespace App\Application;

use App\Domain\Main\Entity\Pokemon;
use App\Domain\Main\Service\User\PokemonHandler;

class PokemonManager
{
    private PokemonHandler $handler;

    public function __construct(PokemonHandler $handler)
    {
        $this->handler = $handler;
    }

    public function fullRestore(Pokemon $pokemon): void
    {
        $this->handler->fullRestore($pokemon);
    }

    public function restoreHP(Pokemon $pokemon, int $HP): void
    {
        $this->handler->restoreHP($pokemon, $HP);
    }
}
