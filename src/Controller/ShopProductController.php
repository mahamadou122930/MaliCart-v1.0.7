<?php

namespace App\Controller;


use App\Entity\ShopProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop', name: 'shop.')]
class ShopProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route(name: 'index')]
    public function index(): Response
    {
        $shopproducts = $this->entityManager->getRepository(ShopProduct::class)->findAll();



        return $this->render('article/index.html.twig', [
            'shopproducts'=> $shopproducts,
        ]);
    }


    #[Route('/product/{slug}', name: 'show')]
    public function show($slug): Response
    {
        $shopproduct = $this->entityManager->getRepository(ShopProduct::class)->findOneBySlug($slug);

        if(!$shopproduct) {
            return $this->redirectToRoute('shop.index');
        }

        return $this->render('article/show.html.twig', [
            'shopproduct'=> $shopproduct,
        ]);
    }
}
