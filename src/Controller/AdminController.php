<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'userController',
        ]);
    }

    #[Route('/category', name: 'category')]
    public function category(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'categoryController',
        ]);
    }

    #[Route('/offer', name: 'offer')]
    public function offer(): Response
    {
        return $this->render('offer/index.html.twig', [
            'controller_name' => 'offerController',
        ]);
    }

}
