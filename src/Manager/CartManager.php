<?php


namespace App\Manager;

use App\Service\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

class CartManager
{
     /**
     * @var CartSessionStorage
     */
    private $cartSessionStorage;

    /**
     * @var OrderFactory
     */
    private $cartFactory;

      /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * CartManager constructor.
     */
    public function __construct(
        CartSessionStorage $cartStorage,
        EntityManagerInterface $entityManager
    ) {
        $this->cartSessionStorage = $cartStorage;
        $this->entityManager = $entityManager;
    }

     /**
     * Ajoute un produit au panier.
     */
    public function addProductToCart($productId, $color, $size, $quantity)
    {
        $cart = $this->cartSessionStorage->getCart();

        $productKey = $productId . '_' . $color->getName() . '_' . $size;

        if (isset($cart[$productKey])) {
            // Si le produit existe déjà dans le panier, mettre à jour la quantité
            $cart[$productKey]['quantity'] += $quantity;
        } else {
            // Ajouter un nouveau produit au panier
            $cart[$productKey] = [
                'product_id' => $productId,
                'color' => $color->getName(),
                'size' => $size,
                'quantity' => $quantity,
            ];
        }
        $this->cartSessionStorage->setCart($cart);

    }
    
      /**
     * Supprime un produit du panier.
     */
    public function removeProductFromCart($productId, $color, $size)
    {
        $cart = $this->cartSessionStorage->getCart();


        $productKey = $productId . '_' . $color . '_' . $size;

        if (isset($cart[$productKey])) {
            unset($cart[$productKey]);
        }

        $cart = $this->cartSessionStorage->setCart($cart);
    }

    /**
     * Met à jour la quantité d'un produit dans le panier.
     */
    public function updateProductQuantity($productId, $color, $size, $quantity)
    {
        $cart = $this->cartSessionStorage->getCart();
        
        $productKey = $productId . '_' . $color . '_' . $size;

        if (isset($cart[$productKey])) {
            $cart[$productKey]['quantity'] = $quantity;
        }

        $cart = $this->cartSessionStorage->setCart($cart);
    }

     /**
     * Gets the current cart.
     */
    public function getCurrentCart()
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart) {
            $cart = [];
        }

        return $cart;
    }

       /**
     * Persists the cart in database and session.
     */
    public function setCart($cart): void
    {
        // Persist in session
        $this->cartSessionStorage->setCart($cart);
    }

}