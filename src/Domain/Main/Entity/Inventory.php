<?php

namespace App\Domain\Main\Entity;

use App\Domain\Main\Entity\InventoryItem;

class Inventory
{
    use IdentifierTrait;

    private User $user;

    /**
     * @var InventoryItem[]
     */
    private $inventoryItems = [];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return InventoryItem[]
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    public function addInventoryItem(InventoryItem $inventoryItem): self
    {
        if (!in_array($inventoryItem, $this->inventoryItems, true)) {
            $this->inventoryItems[] = $inventoryItem;
            $inventoryItem->setInventory($this);
        }

        return $this;
    }

    public function removeInventoryItem(InventoryItem $inventoryItem): self
    {
        if (($key = array_search($inventoryItem, $this->inventoryItems, true)) !== false) {
            unset($this->inventoryItems[$key]);
            // set the owning side to null (unless already changed)
            if ($inventoryItem->getInventory() === $this) {
                $inventoryItem->setInventory(null);
            }
        }

        return $this;
    }
}
