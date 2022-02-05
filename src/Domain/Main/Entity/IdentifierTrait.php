<?php

namespace App\Domain\Main\Entity;

trait IdentifierTrait
{
    private int $id;

    private string $uuid;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
