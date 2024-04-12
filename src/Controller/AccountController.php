<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\ChangePasswordType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account', name: 'account.')]
class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(name: 'info')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('oldpassword')->getData();
            dd($old_pwd);
            if($userPasswordHasher->isPasswordValid($user, $old_pwd)) {

            }
        }

        return $this->render('account/index.html.twig', [
            'account'=> $form->createView()
        ]);
    }

    #[Route('/Wishlist', name: 'myticket')]
    public function wishlist(): Response
    {
        
     
        return $this->render('account/index.html.twig');
    }

    #[Route('/address', name: 'address')]
    public function address(): Response
    {
        return $this->render('account/account_address.html.twig');
    }


    #[Route('/order', name: 'order')]
    public function order(OrderRepository $order): Response
    {

        $orders = $order->findSuccessOrders($this->getUser());
        

        return $this->render('account/account_order.html.twig', [
            'orders'=> $orders,
        ]);
    }

    #[Route('/order/{reference}', name: 'order.show')]
    public function show($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account.order');
        }
                
        return $this->render('account/account_order_show.html.twig', [
            'orders'=> $order
        ]);
    }


}
