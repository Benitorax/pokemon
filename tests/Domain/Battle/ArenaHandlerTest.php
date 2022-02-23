<?php

namespace App\Tests\Domain\Battle;

use PHPUnit\Framework\TestCase;
use App\Domain\Battle\Entity\Arena;
use App\Domain\Helper\PokemonApiInterface;
use App\Domain\Battle\Service\ArenaHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;

class ArenaHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    /** @var MockObject&PokemonApiInterface */
    private $pokemonApi;

    private ArenaHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->pokemonApi = $this->createMock(PokemonApiInterface::class);
        $this->handler = new ArenaHandler($this->entityManager, $this->pokemonApi);
    }

    public function testGetRandomArena(): void
    {
        $this->assertInstanceOf(Arena::class, $this->handler->getRandomArena());
    }
}
