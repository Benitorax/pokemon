<?php

namespace App\Domain\Main\Entity;

class Pokemon
{
    private string $name;

    private int $HP;

    private int $apiId;

    private ?User $trainer;

    private bool $isKO;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHP(): int
    {
        return $this->HP;
    }

    public function setHP(int $HP): self
    {
        $this->HP = $HP;

        return $this;
    }

    public function getApiId(): int
    {
        return $this->apiId;
    }

    public function setApiId(int $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function getTrainer(): ?User
    {
        return $this->trainer;
    }

    public function setTrainer(?User $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getIsKO(): bool
    {
        return $this->isKO;
    }

    public function setIsKO(bool $isKO): self
    {
        $this->isKO = $isKO;

        return $this;
    }
}
