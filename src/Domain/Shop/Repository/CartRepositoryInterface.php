<?php

namespace App\Domain\Shop\Repository;

use App\Domain\Helper\EntityRepositoryInterface;
use App\Domain\Shop\Entity\Cart;

interface CartRepositoryInterface extends EntityRepositoryInterface
{
    public function findOneBy(array $criteria, ?array $orderBy = null): ?Cart;
}
