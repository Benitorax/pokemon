<?php

namespace App\Domain\Shop\Entity;

use App\Domain\Helper\ProductInterface;
use App\Domain\Main\Entity\IdentifierTrait;

class CartItem
{
    use IdentifierTrait;

    private ?Cart $cart;

    private ProductInterface $product;

    private int $quantity;

    public function __construct(ProductInterface $product, int $quantity = 1)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): self
    {
        $this->product = $product;
        $this->quantity = 1;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
