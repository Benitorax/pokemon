<?php

namespace App\Domain\Helper;

use App\Domain\Main\Entity\ItemInterface;

/**
 * Classes that would be in shopping store must implements this interface.
 */
interface ProductInterface extends ItemInterface
{
    public function getCost(): int;
}
