<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\Inventory;
use App\Domain\Main\Entity\InventoryItem;
use App\Domain\Main\Entity\ItemInterface;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Repository\InventoryRepositoryInterface;
use App\Domain\Main\Repository\InventoryItemRepositoryInterface;

class InventoryHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addItem(ItemInterface $item, Inventory $inventory, int $quantity): self
    {
        // checks if item already in inventory
        $repository = $this->entityManager->getRepository(InventoryItem::class);
        $inventoryItem = $repository->findOneBy(['inventory' => $inventory, 'item' => $item]);

        if (null !== $inventoryItem) {
            /** @var InventoryItem $inventoryItem */
            $inventoryItem->setQuantity($quantity);
            $this->entityManager->flush();

            return $this;
        }

        $inventoryItem = new InventoryItem($item, $quantity);
        $inventory->addInventoryItem($inventoryItem);
        $this->entityManager->persist($inventoryItem);
        $this->entityManager->flush();

        return $this;
    }

    public function modifyItem(ItemInterface $item, Inventory $inventory, int $quantity): self
    {
        $repository = $this->entityManager->getRepository(InventoryItem::class);
        $inventoryItem = $repository->findOneBy(['inventory' => $inventory, 'item' => $item]);

        if (null === $inventoryItem) {
            return $this;
        }

        /** @var InventoryItem $inventoryItem */
        $inventoryItem->setQuantity($quantity);
        $this->entityManager->flush();

        return $this;
    }

    public function removeItem(ItemInterface $item, Inventory $inventory): self
    {
        $repository = $this->entityManager->getRepository(InventoryItem::class);
        $inventoryItem = $repository->findOneBy(['inventory' => $inventory, 'item' => $item]);

        if (null === $inventoryItem) {
            return $this;
        }

        /** @var InventoryItem $inventoryItem */
        $inventory->removeInventoryItem($inventoryItem);
        $this->entityManager->remove($inventoryItem);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * Return inventory of given user.
     */
    public function getInventory(User $user): Inventory
    {
        $repository = $this->entityManager->getRepository(Inventory::class);

        if (null !== $inventory = $repository->findOneBy(['user' => $user])) {
            /** @var Inventory $inventory */
            return $inventory;
        }

        $inventory = new Inventory($user);
        $this->entityManager->persist($inventory);
        $this->entityManager->flush();

        return $inventory;
    }
}
