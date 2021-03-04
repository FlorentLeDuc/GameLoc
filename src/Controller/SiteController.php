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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\EditProfilType;
use App\Entity\User;


class SiteController extends AbstractController
{
    #[Route('/', name: 'index',  methods: ['GET', 'POST'])]
    public function index(OfferRepository $offerRepository, Request $request, MailerInterface $mailer): Response
    {

        $offers = $offerRepository->findBy([], [ 
            "publication_date" => "DESC",],
            5
            );
        $form1 = $this->createForm(ContactType::class);

        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
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
            'form1' => $form1->createView()
        ]);
    }

    #[Route('/profil', name: 'profil')]
    public function profil(Request $request, MailerInterface $mailer): Response
    {
        
        $form1 = $this->createForm(ContactType::class);

        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }
        return $this->render('site/profil.html.twig', [
            'controller_name' => 'SiteController',
            'form1' => $form1->createView()
        ]);
    }

    #[Route('/offers', name: 'offers')]
    public function offers(OfferRepository $offerRepository, Request $request, MailerInterface $mailer): Response
    {

        $form1 = $this->createForm(ContactType::class);

        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }
        $offers = $offerRepository->findBy([], [ "publication_date" => "DESC"]);
        return $this->render('site/offers.html.twig', [
            'controller_name' => 'SiteController',
            'offers' => $offers,
            'form1' => $form1->createView()
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

        $form1 = $this->createForm(ContactType::class);

        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }
        return $this->render('site/offer.html.twig', [
            'offer' => $offer,
            'form'  => $form->createView(),
            'form1' => $form1->createView()
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

    #[Route('/editprofil', name: 'editprofil')]
    public function editprofil(Request $request, MailerInterface $mailer, EditProfilType $editprofil): Response
    {
        
        $form1 = $this->createForm(ContactType::class);
        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }

        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('site/editprofil.html.twig', [
            'form1' => $form1->createView(),
            'form' => $form->createView(),
            'controller_name' => 'SiteController',
        ]);
    }

    #[Route('/createoffer', name: 'createoffer', methods: ['GET', 'POST'])]
    public function createoffer(Request $request, MailerInterface $mailer, SluggerInterface $slugger ): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            // code de gestion de upload image
            $imageFile = $form->get('picture')->getData();
            $offer->setPublicationDate(new \DateTime());
            $userConnecte = $this->getUser();
            $offer->setUser($userConnecte);
            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),    // dossier cible
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // supprimer l'image d'avant
                $dossierUpload = $this->getParameter('images_directory');

                $fichierImage = "$dossierUpload/" . $offer->getPicture();
                if (is_file($fichierImage)) {
                unlink($fichierImage);
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $offer->setPicture($newFilename);
            }
            else {
                $offer->setPicture("");     // aucun fichier uploade
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offers');
        }

        $form1 = $this->createForm(ContactType::class);

        $contact = $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@gameloc.com')
                ->subject('Contact depuis le site')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'sujet' => $contact->get('sujet')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
        }
        return $this->render('site/createoffer.html.twig', [
            'controller_name' => 'SiteController',
            'Offer' => $form->createView(),
            'form1' => $form1->createView()
        ]);
    }
}
