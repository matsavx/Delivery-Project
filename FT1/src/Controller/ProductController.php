<?php

namespace App\Controller;

use App\Entity\DeliveryDrink;
use App\Entity\DeliveryKit;
use App\Entity\DeliveryOrder;
use App\Entity\DeliveryPizza;
use App\Entity\DeliveryRoll;
use App\Form\DeliveryOrderFormType;
use App\Repository\DeliveryDrinkRepository;
use App\Repository\DeliveryKitRepository;
use App\Repository\DeliveryPizzaRepository;
use App\Repository\DeliveryRollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use http\Env\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
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
     * @Route("/pizzas", name="pizzaList")
     * @param DeliveryPizzaRepository $pizzaRepository
     * @return Response
     */
    public function pizzaList(DeliveryPizzaRepository $pizzaRepository) : Response {
        $pizzas = $pizzaRepository->findAll();
//        dd($pizzas);

        return $this->render('/pizzaList.html.twig', [
            'title'=> 'Пиццы',
            'pizzas'=> $pizzas
        ]);
    }

//    /**
//     * @Route ("/pizzas/{id<\d+>}", name="pizzaPage")
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function pizzaPage(int $id) : Response {
//        return $this->render('/pizzaList.html.twig', [
//            'controller_name'=>'pizzaPage' . $id
//        ]);
//    }

    /**
     * @Route("/drinks", name="drinkList")
     * @param DeliveryDrinkRepository $drinkRepository
     * @return Response
     */
    public function drinkList(DeliveryDrinkRepository $drinkRepository) : Response {
        $drinks = $drinkRepository->findAll();

        return $this->render('/drinkList.html.twig', [
            'title'=> 'Напитки',
            'drinks'=> $drinks
        ]);
    }

    /**
     * @Route("/rolls", name="rollList")
     * @param DeliveryRollRepository $rollRepository
     * @return Response
     */
    public function rollList(DeliveryRollRepository $rollRepository) : Response {
        $rolls = $rollRepository->findAll();

        return $this->render('/rollList.html.twig', [
            'title'=> 'Роллы',
            'rolls'=> $rolls
        ]);
    }

    /**
     * @Route("/kits", name="kitList")
     * @param DeliveryKitRepository $kitRepository
     * @return Response
     */
    public function kitList(DeliveryKitRepository $kitRepository) : Response {

        $session = $this->session->getId();
        $kits = $kitRepository->findBy(['sessionId'=>$session]);

        return $this->render('/kitList.html.twig', [
            'controller_name'=>'kitsList',
            'title'=> 'Корзина',
            'kits'=> $kits
        ]);
    }

    /**
     * @Route("/pizzas/addingPizza/{id<\d+>}", name="pizzaAdd")

     * @param DeliveryPizza $deliveryPizza
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function kitAddPizza(DeliveryPizza $deliveryPizza,
                                EntityManagerInterface $entityManager) : Response {
        $sessionId = $this->session->getId();
//        $deliveryKit = (new DeliveryKit())->addDeliveryPizzaInKit($deliveryPizza);
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryPizzaInKit($deliveryPizza);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('pizzaList', ['id'=>$deliveryPizza->getId()]);
    }

    /**
     * @Route("/drinks/addingDrink/{id<\d+>}", name="drinkAdd")

     * @param DeliveryDrink $deliveryDrink
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function kitAddDrink(DeliveryDrink $deliveryDrink,
                                EntityManagerInterface $entityManager) : Response {
        $sessionId = $this->session->getId();
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryDrinkInKit($deliveryDrink);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('drinkList', ['id'=>$deliveryDrink->getId()]);
    }

    /**
     * @Route("/rolls/addingRolls/{id<\d+>}", name="rollAdd")

     * @param DeliveryRoll $deliveryRoll
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function kitAddRoll(DeliveryRoll $deliveryRoll,
                                EntityManagerInterface $entityManager) : Response {
        $sessionId = $this->session->getId();
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryRollInKit($deliveryRoll);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('rollList', ['id'=>$deliveryRoll->getId()]);
    }

    /**
     * @Route("/order", name="order")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createOrder(Request $request, EntityManagerInterface $entityManager) : Response {

        $deliveryOrder = new DeliveryOrder();
        $orderForm = $this->createForm(DeliveryOrderFormType::class, $deliveryOrder);
        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $deliveryOrder = $orderForm->getData();
//            dd($orderForm);
            if ($deliveryOrder instanceof DeliveryOrder) {
                $sessionId = $this->session->getId();
                $deliveryOrder->setOrderSessionId($sessionId);

                $entityManager->persist($deliveryOrder);
                $entityManager->flush();
                $this->session->migrate();
            }
            return $this->redirectToRoute('main_page');
        }
        return $this->render('/order.html.twig', [
            'title'=> 'Заказ',
            'form'=>$orderForm->createView()
        ]);
    }

}
