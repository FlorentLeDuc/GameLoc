<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Form\OfferContactType;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\OfferRepository;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SiteController extends AbstractController
{
    #[Route('/', name: 'index',  methods: ['GET', 'POST'])]
    public function index(OfferRepository $offerRepository, Request $request, MailerInterface $mailer): Response
    {

        $offers = $offerRepository->findBy([], [ 
            "publication_date" => "DESC",],
            5
            );
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site GameLoc')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'offers' => $offers,
            'form' => $form->createView()
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

    #[Route('/offer{id}', name: 'offer', methods: ['GET', 'POST'])]
    public function offer(Offer $offer, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(OfferContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($offer->getUser()->getEmail())
                ->subject('Contact au sujet de votre annonce "' . $offer->getTitle() . '"')
                ->htmlTemplate('emails/contact_annonce.html.twig')
                ->context([
                    'offer' => $offer,
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }

        return $this->render('site/offer.html.twig', [
            'offer' => $offer,
            'form' => $form->createView()
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
