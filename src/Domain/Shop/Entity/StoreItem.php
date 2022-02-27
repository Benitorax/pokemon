<?php

namespace App\Domain\Shop\Entity;

use App\Domain\Helper\ProductInterface;
use App\Domain\Main\Entity\IdentifierTrait;

class StoreItem
{
    use IdentifierTrait;

    private ProductInterface $product;

    private bool $isAvailable;

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
