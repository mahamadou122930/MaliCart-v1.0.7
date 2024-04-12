<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager {

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getCart(): array
    {
        return $this->session->get('panier', []);
    }

    public function setCart(array $cart): void
    {
        $this->session->set('panier', $cart);
    }



}