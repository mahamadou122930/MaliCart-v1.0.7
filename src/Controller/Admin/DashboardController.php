<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\ShopProduct;
use App\Entity\ShopProductBrand;
use App\Entity\ShopProductCategory;
use App\Entity\ShopProductColor;
use App\Entity\ShopProductSize;
use App\Entity\ShopProductSubCategory;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        $url = $this->adminUrlGenerator
        ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MaliCart');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class);

        yield MenuItem::section('Produit', 'fa fa-Tags');
        yield MenuItem::subMenu('Orders', 'fa fa-shopping-cart')->setSubItems([
            MenuItem::linkToCrud('Afficher les commandes ', 'fas fa-shopping-cart', Order::class)
        ]);
        yield MenuItem::subMenu('Categorie', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une nouvelle Categorie', 'fas fa-plus', ShopProductCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Categories', 'fas fa-eye', ShopProductCategory::class)
        ]);
        yield MenuItem::subMenu('Sous Categorie', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une nouvelle Sous-Categorie', 'fas fa-plus', ShopProductSubCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Sous-Categories', 'fas fa-eye', ShopProductSubCategory::class)
        ]);
        yield MenuItem::subMenu('Taille', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une Taille de Vêtement', 'fas fa-plus', ShopProductSize::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Tailles des Vêtements', 'fas fa-eye', ShopProductSize::class)
        ]);
        yield MenuItem::subMenu('Marque Produit', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une Marque Produit', 'fas fa-plus', ShopProductBrand::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher tous les Marques', 'fas fa-eye', ShopProductBrand::class)
        ]);
        yield MenuItem::subMenu('Couleur', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter une nouvelle Couleur', 'fas fa-plus', ShopProductColor::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher tous les Couleurs', 'fas fa-eye', ShopProductColor::class)
        ]);
        yield MenuItem::subMenu('Produit', 'fa fa-tags')->setSubItems([
            MenuItem::linkToCrud('Ajouter un nouveau Produit', 'fas fa-plus', ShopProduct::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher tous les Produits', 'fas fa-eye', ShopProduct::class)
        ]);
        yield MenuItem::linkToCrud('Carriers', 'fas fa-truck', Carrier::class);
        
       
    }
}
