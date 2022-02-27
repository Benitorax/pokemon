<?php

namespace App\Domain\Helper;

use App\Domain\Main\Entity\Habitat;
use App\Domain\Main\Entity\Pokemon;

interface PokemonApiInterface
{
    /**
     * Returns random Habitat
     */
    public function randomHabitat(): Habitat;

    /**
     * Returns random pokemon from given habitat.
     */
    public function randomPokemonFromHabitat(Habitat $habitat): Pokemon;

    /**
     * Returns pokemon full HP of given id.
     */
    public function getPokemonFullHP(int $pokemonId): int;
}
