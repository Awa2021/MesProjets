<?php

namespace App\Controller;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    //public function index(): Response
    //{
       // return $this->render('admin/index.html.twig', [
         //   'controller_name' => 'AdminController',
        //]);
        
        public function index(AnnonceRepository $repo): Response
        {
            $annonces = $repo->findAll();
            return $this->render('admin/index.html.twig', [
                'annonces' => $annonces
            ]);
        }
    
    }


