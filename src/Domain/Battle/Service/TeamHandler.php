<?php

namespace App\Domain\Battle\Service;

use App\Domain\Main\Entity\Habitat;
use App\Domain\Helper\PokemonApiInterface;
use App\Domain\Battle\Entity\AdventureTeam;
use App\Domain\Battle\Entity\FightTeam;
use App\Domain\Battle\Entity\TeamInterface;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Entity\Pokemon;

class TeamHandler
{
    private EntityManagerInterface $entityManager;
    private PokemonApiInterface $pokemonApi;

    public function __construct(
        EntityManagerInterface $entityManager,
        PokemonApiInterface $pokemonApi,
    ) {
        $this->entityManager = $entityManager;
        $this->pokemonApi = $pokemonApi;
    }

    /**
     * $type is BattleType::TOURNAMENT or BattleType::ADVENTURE
     */
    public function createNonPlayerTeam(string $type, Habitat $habitat): TeamInterface
    {
        switch ($type) {
            case BattleType::TOURNAMENT:
                $team = new FightTeam();
                $pokemon = $this->pokemonApi->randomPokemonFromHabitat($habitat);
                return $team
                    ->setTrainer(TrainerList::randomTrainer())
                    ->setPokemon1($this->pokemonApi->randomPokemonFromHabitat($habitat))
                    ->setPokemon2($this->pokemonApi->randomPokemonFromHabitat($habitat))
                    ->setPokemon3($this->pokemonApi->randomPokemonFromHabitat($habitat))
                    ->setFighter($pokemon)
                ;
            case BattleType::ADVENTURE:
                return (new AdventureTeam())
                    ->setFighter($this->pokemonApi->randomPokemonFromHabitat($habitat))
                ;
            default:
                throw new \Exception(
                    sprintf(
                        '$type should be value of BattleType::ADVENTURE or BattleType::TOURNAMENT, %s given',
                        $type
                    ),
                    500
                );
        }
    }

    public function addPokemon(Pokemon $pokemon, TeamInterface $team): void
    {
        switch (get_class($team)) {
            case FightTeam::class:
                for ($i = 1; $i <= 3; $i++) {
                    $getter = 'getPokemon' . $i;

                    if (null === $team->$getter()) {
                        $setter = 'setPokemon' . $i;
                        $team->$setter($pokemon);

                        if (1 === $i) {
                            $team->setFighter($pokemon);
                        }
                    }
                }
                break;
            case AdventureTeam::class:
                $team->setFighter($pokemon);
                break;
            default:
                return;
        }

        $this->entityManager->flush();
    }
}
