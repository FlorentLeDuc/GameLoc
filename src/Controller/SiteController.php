<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('site/user.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/game', name: 'game')]
    public function game(): Response
    {
        return $this->render('site/game.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/category', name: 'category')]
    public function category(): Response
    {
        return $this->render('site/category.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/offer', name: 'offer')]
    public function offer(): Response
    {
        return $this->render('site/offer.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/offers', name: 'offers')]
    public function offers(): Response
    {
        return $this->render('site/offers.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/games', name: 'games')]
    public function games(): Response
    {
        return $this->render('site/games.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
        return $this->render('site/profil.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
