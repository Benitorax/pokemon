<?php

namespace App\Application;

use App\Domain\Main\Service\User\PokemonHandler;

class PokemonManager
{
    private PokemonHandler $handler;

    public function __construct(PokemonHandler $handler)
    {
        $this->handler = $handler;
    }
}
