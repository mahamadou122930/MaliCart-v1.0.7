<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account', name: 'account.')]
class SupportController extends AbstractController
{
    #[Route('/support', name: 'support')]
    public function index(): Response
    {
        return $this->render('support/myticket.html.twig');
    }
}
