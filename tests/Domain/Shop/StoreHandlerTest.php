<?php

namespace App\Tests\Domain\Shop;

use PHPUnit\Framework\TestCase;
use App\Domain\Shop\Service\StoreHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Shop\Repository\StoreItemRepositoryInterface;

class StoreHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    private StoreHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new StoreHandler($this->entityManager);
    }

    public function testGetProducts(): void
    {
        $repository = $this->createMock(StoreItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findAll')->willReturn([]);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->handler->getProducts();
    }
}
