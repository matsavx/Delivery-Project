<?php

namespace App\Controller;


use App\Repository\DeliveryDrinkRepository;
use App\Repository\DeliveryPizzaRepository;
use App\Repository\DeliveryRollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

//$session = 1;

class ProductController extends AbstractController
{
//    private int $session = 1;
//    /**
//     * ProductController constructor.
//     * @param int $session
//     */
//    public function __construct(int $session)
//    {
//        $this->session = $session + rand(0,10);
////        $this->session->start();
////        $session = 1;
//    }

//    public function incSession(int $session_first)
//    {
//         = $session_first + 1;
//    }

    #[Route('/', name: 'main_page')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user != null) {
            return $this->render('/index.html.twig', [
                'controller_name' => 'ProductController',
                'user' => $user->getUserIdentifier()
            ]);
        } else return $this->render('/index.html.twig', [
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

        $user = $this->getUser();
        if ($user != null) {
            return $this->render('/pizzaList.html.twig', [
                'title' => 'Пиццы',
                'pizzas' => $pizzas,
                'user' => $user->getUserIdentifier()
            ]);
        } else {
            return $this->render('/pizzaList.html.twig', [
                'title' => 'Пиццы',
                'pizzas' => $pizzas
            ]);
        }
    }

    /**
     * @Route("/drinks", name="drinkList")
     * @param DeliveryDrinkRepository $drinkRepository
     * @return Response
     */
    public function drinkList(DeliveryDrinkRepository $drinkRepository) : Response {
        $drinks = $drinkRepository->findAll();

        $user = $this->getUser();
        if ($user != null) {
            return $this->render('/drinkList.html.twig', [
                'title' => 'Напитки',
                'drinks' => $drinks,
                'user' => $user->getUserIdentifier()
            ]);
        } else {
            return $this->render('/drinkList.html.twig', [
                'title' => 'Напитки',
                'drinks' => $drinks
            ]);
        }
    }

    /**
     * @Route("/rolls", name="rollList")
     * @param DeliveryRollRepository $rollRepository
     * @return Response
     */
    public function rollList(DeliveryRollRepository $rollRepository) : Response {
        $rolls = $rollRepository->findAll();

<<<<<<< HEAD
        $user = $this->getUser();
        if ($user != null) {
            return $this->render('/rollList.html.twig', [
                'title' => 'Роллы',
                'rolls' => $rolls,
                'user' => $user->getUserIdentifier()
            ]);
        } else {
            return $this->render('/rollList.html.twig', [
                'title' => 'Роллы',
                'rolls' => $rolls
            ]);
=======
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

//        global $session;
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
//        global $session;
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryPizzaInKit($deliveryPizza);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('pizzaList', ['id'=>$deliveryPizza->getId()]);
    }

    /**
     * @Route("kits/removePizza/{id<\d+>}", name="removePizza")
     * @param DeliveryKitRepository $kitRepository
     * @param DeliveryKit $deliveryKit
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public  function kitRemovePizza (DeliveryKitRepository $kitRepository, DeliveryKit $deliveryKit, EntityManagerInterface $entityManager) :Response {

        $deliveryKit = $kitRepository->findOneBy(['id'=>$deliveryKit->getId()]);
        $deliveryPizza = $deliveryKit->getDeliveryPizzaInKit();
        $deliveryPizza->removeDeliveryKit($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('kitList', ['id'=>$deliveryKit->getId()]);
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
//        global $session;
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryDrinkInKit($deliveryDrink);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('drinkList', ['id'=>$deliveryDrink->getId()]);
    }

    /**
     * @Route("kits/removeDrink/{id<\d+>}", name="removeDrink")
     * @param DeliveryKitRepository $kitRepository
     * @param DeliveryKit $deliveryKit
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public  function kitRemoveDrink (DeliveryKitRepository $kitRepository, DeliveryKit $deliveryKit, EntityManagerInterface $entityManager) :Response {

        $deliveryKit = $kitRepository->findOneBy(['id'=>$deliveryKit->getId()]);
        $deliveryDrink = $deliveryKit->getDeliveryDrinkInKit();
        $deliveryDrink->removeDeliveryKit($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('kitList', ['id'=>$deliveryKit->getId()]);
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
//        global $session;
        $deliveryKit = (new DeliveryKit())
            -> setSessionId($sessionId)
            -> setDeliveryRollInKit($deliveryRoll);

        $entityManager->persist($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('rollList', ['id'=>$deliveryRoll->getId()]);
    }

    /**
     * @Route("kits/removeRoll/{id<\d+>}", name="removeRoll")
     * @param DeliveryKitRepository $kitRepository
     * @param DeliveryKit $deliveryKit
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public  function kitRemoveRoll (DeliveryKitRepository $kitRepository, DeliveryKit $deliveryKit, EntityManagerInterface $entityManager) :Response {

        $deliveryKit = $kitRepository->findOneBy(['id'=>$deliveryKit->getId()]);
        $deliveryRoll = $deliveryKit->getDeliveryRollInKit();
        $deliveryRoll->removeDeliveryKit($deliveryKit);
        $entityManager->flush();

        return $this->redirectToRoute('kitList', ['id'=>$deliveryKit->getId()]);
    }

    /**
     * @Route("/order", name="order")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createOrder(Request $request, EntityManagerInterface $entityManager) : Response {

//        global $session;
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
//                $session++;
//                $this->incSession($this->session);
                $this->session->migrate();
            }
            return $this->redirectToRoute('main_page');
>>>>>>> 21276cdc695205429846f3b8307ad363872d0306
        }
    }

}
