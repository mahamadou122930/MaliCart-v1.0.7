<?php

namespace App\Storage;

use App\Entity\Order;
use App\Repository\OrderRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage 
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The cart repository.
     *
     * @var OrderRepository
     */
    private $cartRepository;
    
    /**
     * @var string
     */
    public const CART_KEY_NAME = 'cart';

      /**
     * CartSessionStorage constructor.
     */
    public function __construct(RequestStack $requestStack, OrderRepository $cartRepository)
    {
        $this->requestStack = $requestStack;
        $this->cartRepository = $cartRepository;
    }

    public function getCart():array
    {
        $cart = $this->getSession()->get(self::CART_KEY_NAME, []);
    
        // Si le panier n'existe pas dans la session, retournez un tableau vide
        return $cart;
    }
     /**
     * Sets the cart in session.
     */
    public function setCart($cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart);
    }


    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}