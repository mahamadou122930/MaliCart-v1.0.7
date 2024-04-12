<?php


namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

  

    public function createOrder(array $orderDetails, $user, array $orderInfo): void
    {
        $order = new Order();
        $date = new \DateTimeImmutable();
        $reference = $date->format('dmY').uniqid(true);

        $order->setReference($reference);
        $order->setUser($user);
        $order->setCreatedAt($date);
        $order->setUpdatedAt($date);
        $order->setDelivery($orderInfo['deliveryAddress']);
        $order->setIsPaid(0);
        $order->setDiscount(0);
        $order->setCarrierName($orderInfo['transporterName']);
        $order->setCarrierPrice($orderInfo['transportPrice']);
        $order->setState(0);
        
        $this->entityManager->persist($order);

        foreach ($orderDetails as $product) {
            $orderDetails = new OrderDetails();
            $orderDetails->setMyOrder($order);
            $orderDetails->setProduct($product['product']->getName());
            $orderDetails->setQuantity($product['quantity']);
            $orderDetails->setColor($product['color']);
            $orderDetails->setSize($product['size']);
            $orderDetails->setPrice($product['product']->getPrice());
            $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

            $this->entityManager->persist($orderDetails);
        }

        $this->entityManager->flush();
    }


}