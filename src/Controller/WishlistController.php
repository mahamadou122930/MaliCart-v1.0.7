<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'account.wishlist')]
    public function index(): Response
    {
        return $this->render('wishlist/index.html.twig');
    }
}
