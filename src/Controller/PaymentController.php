<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account', name: 'account.')]
class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig');
    }
}
