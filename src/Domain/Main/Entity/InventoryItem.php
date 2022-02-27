<?php

namespace App\Domain\Main\Entity;

use App\Domain\Main\Entity\ItemInterface;

class InventoryItem
{
    use IdentifierTrait;

    private ?Inventory $inventory;

    private ItemInterface $item;

    private int $quantity;

    public function __construct(ItemInterface $item, int $quantity = 1)
    {
        $this->item = $item;
        $this->quantity = $quantity;
    }


    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    public function setItem(ItemInterface $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
