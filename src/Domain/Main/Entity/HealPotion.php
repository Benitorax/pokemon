<?php

namespace App\Domain\Main\Entity;

use App\Domain\Helper\ProductInterface;

class HealPotion implements ProductInterface
{
    use IdentifierTrait;

    private string $name;

    private string $category;

    private string $description;

    private float $healedHp;

    private string $spriteUrl;

    private int $cost;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHealedHp(): float
    {
        return $this->healedHp;
    }

    public function setHealedHp(float $healedHp): self
    {
        $this->healedHp = $healedHp;

        return $this;
    }

    public function getSpriteUrl(): string
    {
        return $this->spriteUrl;
    }

    public function setSpriteUrl(string $spriteUrl): self
    {
        $this->spriteUrl = $spriteUrl;

        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
