<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account', name: 'account.')]
class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'myticket')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig');
    }
}
