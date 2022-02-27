<?php

namespace App\Domain\Shop\Entity;

use App\Domain\Main\Entity\User;
use App\Domain\Main\Entity\IdentifierTrait;

class Cart
{
    use IdentifierTrait;

    private User $user;

    /**
     * @var CartItem[]
     */
    private $cartItems = [];

    public function getUser(): User
    {
        return $this->user;
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return CartItem[]
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!in_array($cartItem, $this->cartItems, true)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if (($key = array_search($cartItem, $this->cartItems, true)) !== false) {
            unset($this->cartItems[$key]);
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }

    public function getSum(): int
    {
        $sum = 0;

        foreach ($this->cartItems as $cartItem) {
            $product = $cartItem->getProduct();
            $sum += $product->getCost() * $cartItem->getQuantity();
        }

        return $sum;
    }

    public function getQuantity(): int
    {
        return count($this->cartItems);
    }
}
