<?php

namespace App\Controller;


use App\Repository\DeliveryDrinkRepository;
use App\Repository\DeliveryPizzaRepository;
use App\Repository\DeliveryRollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
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
        }
    }

}
