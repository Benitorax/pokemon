<?php

namespace App\Domain\Helper;

use App\Domain\Main\Entity\Habitat;
use App\Domain\Main\Entity\Pokemon;

interface PokemonApiInterface
{
    /**
     * Get random Habitat
     */
    public function randomHabitat(): Habitat;

    /**
     * Get random pokemon from given habitat.
     */
    public function randomPokemonFromHabitat(Habitat $habitat): Pokemon;
}
