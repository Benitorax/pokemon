<?php

namespace App\Domain\Main\Entity;

/**
 * Classes that would be in inventory must implements this interface.
 */
interface ItemInterface
{
    public function getName(): string;

    public function getDescription(): string;
}
