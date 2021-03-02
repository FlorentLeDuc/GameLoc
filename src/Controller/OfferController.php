<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/offer')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'offer_index', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

                        // code de gestion de upload image
                        $imageFile = $form->get('picture')->getData();

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

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'offer_show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'offer_delete', methods: ['DELETE'])]
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index');
    }
}
