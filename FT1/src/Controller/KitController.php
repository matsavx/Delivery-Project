<?php

namespace App\Controller;

use App\Entity\DeliveryDrink;
use App\Entity\DeliveryKit;
use App\Entity\DeliveryPizza;
use App\Entity\DeliveryRoll;
use App\Repository\DeliveryKitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class KitController extends AbstractController
{
    private SessionInterface $session;

    /**
     * KitController constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
    }

    /**
     * @Route("/kits", name="kitList")
     * @param DeliveryKitRepository $kitRepository
     * @return Response
     */
    public function kitList(DeliveryKitRepository $kitRepository) : Response {

        $session = $this->session->getId();
        $kits = $kitRepository->findBy(['sessionId'=>$session]);

        $user = $this->getUser();
        if ($user != null) {
            return $this->render('/kitList.html.twig', [
                'controller_name' => 'kitsList',
                'title' => 'Корзина',
                'kits' => $kits,
                'user' => $user->getUserIdentifier()
            ]);
        } else {
            return $this->render('/kitList.html.twig', [
                'controller_name' => 'kitsList',
                'title' => 'Корзина',
                'kits' => $kits
            ]);
        }
    }

    /**
     * @Route("/pizzas/addingPizza/{id<\d+>}", name="pizzaAdd")

     * @param DeliveryPizza $deliveryPizza
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function kitAddPizza(DeliveryPizza $deliveryPizza,
                                EntityManagerInterface $entityManager) : Response {
        $user = $this->getUser();
        if ($user != null) {
            $sessionId = $this->session->getId();
            $deliveryKit = (new DeliveryKit())
                ->setSessionId($sessionId)
                ->setDeliveryPizzaInKit($deliveryPizza)
                ->setKitClientId($user->getId());

            $entityManager->persist($deliveryKit);
            $entityManager->flush();

            return $this->redirectToRoute('pizzaList', ['id' => $deliveryPizza->getId()]);
        } else {
            return $this->redirectToRoute('app_login');
        }
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
        $user = $this->getUser();
        if ($user != null) {
            $sessionId = $this->session->getId();
            $deliveryKit = (new DeliveryKit())
                ->setSessionId($sessionId)
                ->setDeliveryDrinkInKit($deliveryDrink)
                ->setKitClientId($user->getId());

            $entityManager->persist($deliveryKit);
            $entityManager->flush();

            return $this->redirectToRoute('drinkList', ['id' => $deliveryDrink->getId()]);
        } else {
            return $this->redirectToRoute('app_login');
        }
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
        $user = $this->getUser();
        if ($user != null) {
            $sessionId = $this->session->getId();
            $deliveryKit = (new DeliveryKit())
                ->setSessionId($sessionId)
                ->setDeliveryRollInKit($deliveryRoll)
                ->setKitClientId($user->getId());

            $entityManager->persist($deliveryKit);
            $entityManager->flush();

            return $this->redirectToRoute('rollList', ['id' => $deliveryRoll->getId()]);
        } else {
            return $this->redirectToRoute('app_login');
        }
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
}
