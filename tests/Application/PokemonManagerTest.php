<?php

namespace App\Tests\Application;

use App\Application\PokemonManager;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Main\Service\User\PokemonHandler;
use PHPUnit\Framework\TestCase;

class PokemonManagerTest extends TestCase
{
    /** @var MockObject&PokemonHandler */
    private $pokemonHandler;

    private PokemonManager $manager;

    protected function setUp(): void
    {
        $this->pokemonHandler = $this->createMock(PokemonHandler::class);
        $this->manager = new PokemonManager($this->pokemonHandler);
    }
}
