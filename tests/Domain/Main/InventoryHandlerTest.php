<?php

namespace App\Tests\Domain\Shop;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Pokeball;
use App\Domain\Main\Entity\Inventory;
use App\Domain\Main\Entity\InventoryItem;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Service\User\InventoryHandler;
use App\Domain\Main\Repository\InventoryRepositoryInterface;
use App\Domain\Main\Repository\InventoryItemRepositoryInterface;

class InventoryHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    private InventoryHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new InventoryHandler($this->entityManager);
    }

    public function testAddItem(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $inventory = (new Inventory($user));
        $repository = $this->createMock(InventoryItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->addItem($pokeball, $inventory, 3);
        $inventoryItem = $inventory->getInventoryItems()[0];
        $this->assertSame(3, $inventoryItem->getQuantity());
    }

    public function testAddItemAlreadyInInventory(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $inventoryItem = new InventoryItem($pokeball, 1);
        $inventory = (new Inventory($user))->addInventoryItem($inventoryItem);
        $repository = $this->createMock(InventoryItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($inventoryItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->addItem($pokeball, $inventory, 3);
        $this->assertSame(3, $inventoryItem->getQuantity());
    }

    public function testModifyItem(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $inventoryItem = new InventoryItem($pokeball, 1);
        $inventory = (new Inventory($user))->addInventoryItem($inventoryItem);
        $repository = $this->createMock(InventoryItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($inventoryItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->modifyItem($pokeball, $inventory, 3);
        $this->assertSame(3, $inventoryItem->getQuantity());
    }

    public function testRemoveItem(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $inventoryItem = new InventoryItem($pokeball);
        $inventory = (new Inventory($user))->addInventoryItem($inventoryItem);
        $repository = $this->createMock(InventoryItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($inventoryItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('remove');
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->removeItem($pokeball, $inventory);
    }

    public function testRemoveItemNotInInventory(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $inventoryItem = new InventoryItem($pokeball);
        $inventory = (new Inventory($user))->addInventoryItem($inventoryItem);
        $repository = $this->createMock(InventoryItemRepositoryInterface::class);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->handler->removeItem($pokeball, $inventory);
    }

    public function testGetInventoryWhenAlreadyCreated(): void
    {
        $user = new User();
        $repository = $this->createMock(InventoryRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(new Inventory($user));
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->handler->getInventory($user);
    }

    public function testGetInventoryWhenNotExisted(): void
    {
        $repository = $this->createMock(InventoryRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $inventory = $this->handler->getInventory(new User());
        $this->assertInstanceOf(Inventory::class, $inventory);
    }
}
