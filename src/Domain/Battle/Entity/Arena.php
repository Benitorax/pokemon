<?php

namespace App\Domain\Battle\Entity;

use App\Domain\Main\Entity\Habitat;
use App\Domain\Main\Entity\IdentifierTrait;

class Arena
{
    use IdentifierTrait;

    private Habitat $habitat;

    public function getHabitat(): Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(Habitat $habitat): self
    {
        $this->habitat = $habitat;

        return $this;
    }
}
