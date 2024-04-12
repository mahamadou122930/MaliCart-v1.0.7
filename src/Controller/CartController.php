<?php

namespace App\Controller;

use App\Entity\ShopProductColor;
use App\Repository\ShopProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cart', name: 'cart.')]
class CartController extends AbstractController
{

    #[Route( name: 'index')]
    public function index(SessionInterface $session, ShopProductRepository $productRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];
        $totalPrice = 0;
        
        foreach($panier as $id => $item) {
            $color = $item['color'];
            $size = $item['size'];
            $product = $productRepository->find($id);
            $quantity = $item['quantity'];
            $subtotal = $product->getPrice() * $quantity;
            $totalPrice += $subtotal;
            $panierWithData [] = [
                'product' => $product,
                'quantity' => $quantity,
                'color' => $color,
                'size' => $size,
                'subtotal' => $subtotal,
            ];
        }
        
        return $this->render('cart/index.html.twig', [
            'items'=> $panierWithData,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'add')]
    public function add($id, SessionInterface $session, Request $request, EntityManagerInterface $entityManager)
    {
        $panier = $session->get('panier', []);
    
        $colorId = $request->request->get('color'); // Récupération de l'identifiant de couleur
        $color =$entityManager->getRepository(ShopProductColor::class)->find($colorId); // Remplacer 'Color' par le nom de votre entité Color

        $size = $request->request->get('size');
        $quantity = $request->request->getInt('quantity');

        // Vérifier si le produit avec cet identifiant existe déjà dans le panier
        $productId = $id . '_' . $color->getName() . '_' . $size;

        if (!empty($panier[$productId])) {
            // Produit déjà existant avec la même couleur et taille, incrémenter la quantité
            $panier[$productId]['quantity'] += $quantity;
        } else {
            // Nouveau produit, ajouter une nouvelle ligne avec l'id du produit et le nom de la couleur
            $panier[$productId] = [
                'product_id' => $id,
                'color' => $color->getName(), // Récupérer le nom de la couleur
                'size' => $size,
                'quantity' => $quantity,
            ];
        }


        $session->set('panier', $panier);

        return $this->redirectToRoute('cart.index');

    }
    

    #[Route('/panier/remove/{product_id}/{color}/{size}', name: 'remove')]
    public function remove($product_id, $color, $size, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        // Générer l'identifiant unique basé sur les paramètres de l'URL
        $uniqueId = $product_id . '_' . $color . '_' . $size;

        // Vérifier si l'élément du panier existe avant de le supprimer
        if (!empty($panier[$uniqueId])) {
            unset($panier[$uniqueId]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('cart.index');
    }

    #[Route('/panier/update/{product_id}/{color}/{size}', name: 'update')]
    public function update($product_id, $color, $size, SessionInterface $session, Request $request)
    {
        $panier = $session->get('panier', []);
    
                // Générer l'identifiant unique basé sur les paramètres de l'URL
                $uniqueId = $product_id . '_' . $color . '_' . $size;
        // Récupérer la nouvelle quantité depuis le formulaire
        $newQuantity = $request->request->getInt('quantity');
    
        // Vérifier si l'élément du panier existe avant de mettre à jour la quantité
        if (!empty($panier[$uniqueId])) {
            if ($newQuantity < 1) {
                // Si la quantité est inférieure à 1, supprimer l'élément du panier
                unset($panier[$uniqueId]);
            } else {
                $panier[$uniqueId]['quantity'] = $newQuantity;
            }
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('cart.index');
    }
}
