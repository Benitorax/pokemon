<?php

namespace App\Domain\Shop\Service;

use App\Domain\Main\Entity\User;
use App\Domain\Shop\Entity\Cart;
use App\Domain\Shop\Entity\CartItem;
use App\Domain\Helper\ProductInterface;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Service\User\InventoryHandler;
use App\Domain\Shop\Repository\CartItemRepositoryInterface;

class CartHandler
{
    private EntityManagerInterface $entityManager;

    private InventoryHandler $inventoryHandler;

    public function __construct(EntityManagerInterface $entityManager, InventoryHandler $inventoryHandler)
    {
        $this->entityManager = $entityManager;
        $this->inventoryHandler = $inventoryHandler;
    }

    public function addProduct(ProductInterface $product, Cart $cart, int $quantity): self
    {
        // checks if product already in cart
        $repository = $this->entityManager->getRepository(CartItem::class);
        $cartItem = $repository->findOneBy(['cart' => $cart, 'product' => $product]);

        if (null !== $cartItem) {
            /** @var CartItem $cartItem */
            $cartItem->setQuantity($quantity);
            $this->entityManager->flush();

            return $this;
        }

        $cartItem = new CartItem($product, $quantity);
        $cart->addCartItem($cartItem);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $this;
    }

    public function modifyProduct(ProductInterface $product, Cart $cart, int $quantity): self
    {
        $repository = $this->entityManager->getRepository(CartItem::class);
        $cartItem = $repository->findOneBy(['cart' => $cart, 'product' => $product]);

        if (null === $cartItem) {
            return $this;
        }

        /** @var CartItem $cartItem */
        $cartItem->setQuantity($quantity);
        $this->entityManager->flush();

        return $this;
    }

    public function removeProduct(ProductInterface $product, Cart $cart): self
    {
        $repository = $this->entityManager->getRepository(CartItem::class);
        $cartItem = $repository->findOneBy(['cart' => $cart, 'product' => $product]);

        if (null === $cartItem) {
            return $this;
        }

        /** @var CartItem $cartItem */
        $cart->removeCartItem($cartItem);
        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();

        return $this;
    }

    public function clear(Cart $cart): self
    {
        foreach ($cart->getCartItems() as $cartItem) {
            $cart->removeCartItem($cartItem);
            $this->entityManager->remove($cartItem);
        }

        $this->entityManager->flush();

        return $this;
    }

    /**
     * Return true if purchase is successful, false otherwise.
     */
    public function purchase(Cart $cart): bool
    {
        $sum = $cart->getSum();
        $user = $cart->getUser();
        $cartItems = $cart->getCartItems();

        if (count($cartItems) === 0 || $user->getPokeDollar() < $sum) {
            return false;
        }

        $inventory = $this->inventoryHandler->getInventory($user);

        foreach ($cartItems as $cartItem) {
            $this->inventoryHandler->addItem(
                $cartItem->getProduct(),
                $inventory,
                $cartItem->getQuantity()
            );
            $cart->removeCartItem($cartItem);
            $this->entityManager->remove($cartItem);
        }

        $user->decreasePokedollar($sum);
        $this->entityManager->flush();

        return true;
    }

    /**
     * Return Cart of given user.
     */
    public function getCart(User $user): Cart
    {
        $repository = $this->entityManager->getRepository(Cart::class);

        if (null !== $cart = $repository->findOneBy(['user' => $user])) {
            /** @var Cart $cart */
            return $cart;
        }

        $cart = new Cart($user);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}
