<?php

namespace App\Domain\Shop\Service;

use App\Domain\Shop\Entity\StoreItem;
use App\Domain\Helper\ProductInterface;
use App\Domain\Helper\EntityManagerInterface;

class StoreHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ProductInterface[]
     */
    public function getProducts()
    {
        $repository = $this->entityManager->getRepository(StoreItem::class);

        /** @var ProductInterface[] */
        return $repository->findAll();
    }
}
