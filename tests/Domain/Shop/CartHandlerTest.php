<?php

namespace App\Tests\Domain\Shop;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Shop\Entity\Cart;
use App\Domain\Shop\Entity\CartItem;
use App\Domain\Shop\Service\CartHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Domain\Helper\EntityManagerInterface;
use App\Domain\Main\Entity\Pokeball;
use App\Domain\Main\Service\User\InventoryHandler;
use App\Domain\Shop\Repository\CartItemRepositoryInterface;
use App\Domain\Shop\Repository\CartRepositoryInterface;

class CartHandlerTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private $entityManager;

    /** @var MockObject&InventoryHandler */
    private $inventoryHandler;


    private CartHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->inventoryHandler = $this->createMock(InventoryHandler::class);
        $this->handler = new CartHandler($this->entityManager, $this->inventoryHandler);
    }

    public function testAddProduct(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cart = (new Cart($user));
        $repository = $this->createMock(CartItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->addProduct($pokeball, $cart, 3);
        $cartItem = $cart->getCartItems()[0];
        $this->assertSame(3, $cartItem->getQuantity());
    }

    public function testAddProductAlreadyInCart(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cartItem = new CartItem($pokeball, 1);
        $cart = (new Cart($user))->addCartItem($cartItem);
        $repository = $this->createMock(CartItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($cartItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->addProduct($pokeball, $cart, 3);
        $this->assertSame(3, $cartItem->getQuantity());
    }

    public function testModifyProduct(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cartItem = new CartItem($pokeball, 1);
        $cart = (new Cart($user))->addCartItem($cartItem);
        $repository = $this->createMock(CartItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($cartItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->modifyProduct($pokeball, $cart, 3);
        $this->assertSame(3, $cartItem->getQuantity());
    }

    public function testRemoveProduct(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cartItem = new CartItem($pokeball);
        $cart = (new Cart($user))->addCartItem($cartItem);
        $repository = $this->createMock(CartItemRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn($cartItem);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('remove');
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->removeProduct($pokeball, $cart);
    }

    public function testRemoveProductNotInCart(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cartItem = new CartItem($pokeball);
        $cart = (new Cart($user))->addCartItem($cartItem);
        $repository = $this->createMock(CartItemRepositoryInterface::class);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->handler->removeProduct($pokeball, $cart);
    }

    public function testClear(): void
    {
        $user = new User();
        $pokeball = new Pokeball();
        $cart = new Cart($user);
        $cart->addCartItem(new CartItem($pokeball));
        $this->entityManager->expects($this->once())->method('remove');
        $this->entityManager->expects($this->once())->method('flush');
        $this->handler->clear($cart);
    }

    public function testPurchaseWhenEmptyCart(): void
    {
        $user = (new User())->increasePokedollar(200);
        $cart = new Cart($user);
        $this->inventoryHandler->expects($this->exactly(0))->method('getInventory');
        $this->handler->purchase($cart);
    }

    public function testPurchaseWhenNotEnoughPokedollar(): void
    {
        $user = (new User())->increasePokedollar(100);
        $pokeball = (new Pokeball())->setCost(200);
        $cart = new Cart($user);
        $cart->addCartItem(new CartItem($pokeball));
        $this->inventoryHandler->expects($this->exactly(0))->method('getInventory');
        $this->handler->purchase($cart);
    }

    public function testSuccessPurchase(): void
    {
        $user = (new User())->increasePokedollar(200);
        $cart = new Cart($user);
        $pokeball = (new Pokeball())->setCost(200);
        $cart->addCartItem(new CartItem($pokeball));
        $this->inventoryHandler->expects($this->once())->method('getInventory');
        $this->handler->purchase($cart);
    }

    public function testGetCartWhenAlreadyCreated(): void
    {
        $user = new User();
        $repository = $this->createMock(CartRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(new Cart($user));
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->handler->getCart($user);
    }

    public function testGetCartWhenNotExisted(): void
    {
        $repository = $this->createMock(CartRepositoryInterface::class);
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);
        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($repository);
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        $cart = $this->handler->getCart(new User());
        $this->assertInstanceOf(Cart::class, $cart);
    }
}
