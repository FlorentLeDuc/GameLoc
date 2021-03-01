<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;

class SiteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findBy([], [ "publication_date" => "DESC"]);
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'offers' => $offers,
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

    #[Route('/offers', name: 'offers')]
    public function offers(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findBy([], [ "publication_date" => "DESC"]);
        return $this->render('site/offers.html.twig', [
            'controller_name' => 'SiteController',
            'offers' => $offers,
        ]);
    }

    #[Route('/offer', name: 'offer')]
    public function offer(): Response
    {
        return $this->render('site/offer.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('site/register.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('site/login.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
