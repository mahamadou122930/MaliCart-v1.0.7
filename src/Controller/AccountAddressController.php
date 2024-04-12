<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/address', name: 'address.')]
class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

   
    #[Route('/add_new_address', name: 'add')]
    public function add(Request $r) {
        
        $address = new Address();

        $addressform = $this->createForm(AddressType::class, $address);

        $addressform->handleRequest($r);

        if ($addressform->isSubmitted() && $addressform->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash('success', 'l\'adresse à bien été créer');

            return $this->redirectToRoute('account.address');
        }

        return $this->render('account/account_address_add.html.twig', [
            'form'=> $addressform->createView()
        ]);

    }

    #[Route('/edit_address/{id}', name: 'edit')]
    public function edit(Request $r, $id) {
        
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account.address');
        }
        $form = $this->createForm(AddressType::class, $address);

        $form ->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'La modification de l\'address à bien été prise en Compte');
             return $this->redirectToRoute('account.address');
        }

        return $this->render('account/account_address_edit.html.twig', [
            'form'=> $form->createView()
        ]);

    }

    #[Route('/remove_address/{id}', name: 'remove')]
    public function remove(Address $address):Response {
        
        $this->entityManager->remove($address);
        $this->entityManager->flush();

        $this->addFlash('success', 'l\' a bien été Supprimée');

        return $this->redirectToRoute('account.address');
        
    }
}
