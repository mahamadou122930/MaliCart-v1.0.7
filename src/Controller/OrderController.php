<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Entity\User;
use App\Form\OrderCarrierType;
use App\Form\OrderType;
use App\Repository\ShopProductRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/order', name: 'order.')]
class OrderController extends AbstractController
{
    private $orderService;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager,OrderService $orderService)
    {
        $this->entityManager = $entityManager;
        $this->orderService = $orderService;  
    }

    #[Route('/proceed-to-checkout', name: 'checkout')]
    public function proceedToCheckout(SessionInterface $session, ShopProductRepository $shopProductRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];
        $carrierPrice = 0;
        $totalPrice = 0;

        foreach($panier as $id => $item) {
            $color = $item['color'];
            $size = $item['size'];
            $product = $shopProductRepository->find($id);
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

            // Créer un tableau d'informations de la commande
        $orderInfo = [
            'deliveryAddress' => null,
            'transporterName' => null,
            'transportPrice' => $carrierPrice,
            // ... ajoute d'autres informations de commande ici ...
        ];

        // Créer les détails de la commande (OrderDetails)
        $orderDetails = [];
        foreach ($panierWithData as $product) {
            $orderDetails[] = [
                'product' => $product['product'],
                'quantity' => $product['quantity'],
                'color' => $product['color'],
                'size' => $product['size'],
                'subtotal' => $product['product']->getPrice() * $product['quantity'],
            ];
        }

        // Stocker le tableau global d'informations de la commande dans la session
        $session->set('current_order', [
            'order_info' => $orderInfo,
            'order_details' => $orderDetails,
        ]);

        return $this->redirectToRoute('order.detail');

       
    }

    #[Route('/checkout-details', name: 'detail')]
    public function index(SessionInterface $session, Request $request): Response
    {
        $currentOrder = $session->get('current_order', []);

    if (!$this->getUser()->getAddresses()->getValues())
    {
         return $this->redirectToRoute('address.add');
    }

    $shippingselect = $this->createForm(OrderType::class, null, [
        'user'=> $this->getUser()
    ]);

    $shippingselect->handleRequest($request);

    if ($shippingselect->isSubmitted() && $shippingselect->isValid()) {
        $delivery = $shippingselect->get('adresses')->getData();
        $deliveryContent = $delivery->getFirstname().' '.$delivery->getLastname();
        $deliveryContent .= '<br/>'.$delivery->getPhone();
        if ($delivery->getCompany()) {
            $deliveryContent .= '<br/>'.$delivery->getCompany();
        }

        $deliveryContent .= '<br/>'.$delivery->getAddress();
        $deliveryContent .= '<br/>'.$delivery->getPostal().' '.$delivery->getCity();
        $deliveryContent .= '<br/>'.$delivery->getCountry();

        // Mettre à jour l'adresse de livraison dans l'order_info
        $currentOrder['order_info']['deliveryAddress'] = $deliveryContent;

        // Stocker la mise à jour dans la session
        $session->set('current_order', $currentOrder);

        return $this->redirectToRoute('order.shipping');
        }

        return $this->render('order/index.html.twig', [
            'form'=> $shippingselect->createView(),
            'current_order' => $currentOrder, // Passer le tableau complet de la commande
        ]);
    }

    #[Route('/checkout-shippings', name: 'shipping')]
    public function methodshipping(SessionInterface $session, Request $request): Response
    {
        $currentOrder = $session->get('current_order', []);

        $carriers = $this->entityManager->getRepository(Carrier::class)->findAll();


        // Crée le formulaire en utilisant le OrderCarrierType
        $form = $this->createForm(OrderCarrierType::class);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCarrier = $form->get('carrier')->getData();

            // Mettre à jour les informations du transporteur dans current_order
            $currentOrder['order_info']['transporterName'] = $selectedCarrier->getName();
            $currentOrder['order_info']['transportPrice'] = $selectedCarrier->getPrice();


            // Stocker la mise à jour dans la session
            $session->set('current_order', $currentOrder);
            
            return $this->redirectToRoute('order.payment');               
        }
        return $this->render('order/shipping_method.html.twig', [
            'currentOrder'=> $currentOrder,
            'carriers' => $carriers,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/checkout-payment', name: 'payment')]
    public function payment(SessionInterface $session): Response
    {
        $currentOrder = $session->get('current_order', []);
        $user = $this->getUser();

        // Utilisez le service OrderService pour enregistrer la commande en base de données
        $this->orderService->createOrder($currentOrder['order_details'], $user, $currentOrder['order_info']);



        return $this->render('order/payment_method.html.twig', [
            'currentOrder'=> $currentOrder,
        ]);
    }

}
