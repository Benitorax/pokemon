<?php

namespace App\Domain\Shop\Repository;

use App\Domain\Helper\EntityRepositoryInterface;
use App\Domain\Shop\Entity\CartItem;

interface CartItemRepositoryInterface extends EntityRepositoryInterface
{
    public function findOneBy(array $criteria, ?array $orderBy = null): ?CartItem;
}
