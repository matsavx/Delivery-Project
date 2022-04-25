<?php

namespace App\Controller;

use App\Entity\DeliveryOrder;
use App\Form\DeliveryOrderFormType;
use App\Repository\DeliveryKitRepository;
use App\Repository\DeliveryOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private SessionInterface $session;

    /**
     * ProductController constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
    }

    /**
     * @Route("/order", name="order")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createOrder(Request $request, EntityManagerInterface $entityManager) : Response {

        $user = $this->getUser();
        $userId = $user->getId();
        $date = new \DateTime();
        $date->add(new \DateInterval('PT10H'));
        $deliveryOrder = new DeliveryOrder();
        $orderForm = $this->createForm(DeliveryOrderFormType::class, $deliveryOrder);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $deliveryOrder = $orderForm->getData();
            if ($deliveryOrder instanceof DeliveryOrder) {
                $sessionId = $this->session->getId();
                $deliveryOrder->setOrderSessionId($sessionId);
                $deliveryOrder->setOrderClientId($userId);
                $deliveryOrder->setOrderDate($date);

                $entityManager->persist($deliveryOrder);
                $entityManager->flush();
                $this->session->migrate();
            }
            return $this->redirectToRoute('main_page');
        }
        return $this->render('/order.html.twig', [
            'title'=> 'Заказ',
            'form'=>$orderForm->createView(),
            'user' => $user->getUserIdentifier()
        ]);
    }

    /**
     * @Route("/history", name="history")
     *
     * @param DeliveryOrderRepository $orderRepository
     * @param DeliveryKitRepository $kitRepository
     * @return Response
     */
    public function orderHistory(DeliveryOrderRepository $orderRepository, DeliveryKitRepository $kitRepository): Response
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['orderClientId'=>$user->getId()]);
        $kits = $kitRepository->findBy(['kitClientId'=>$user->getId()]);

        return $this->render('/orderHistory.html.twig', [
            'controller_name'=>'ordersHistory',
            'title'=> 'История заказов',
            'orders'=> $orders,
            'kits'=> $kits,
            'user' => $user->getUserIdentifier()
        ]);
    }
}
