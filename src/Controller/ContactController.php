<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $data = new ContactDTO();
        $form= $this->createForm(ContactType::class, $data);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('contact/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
