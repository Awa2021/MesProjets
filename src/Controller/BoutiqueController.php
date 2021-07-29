<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="boutique")
     */
    public function index(): Response
    {
        return $this->render('boutique/index.html.twig', [
            'controller_name' => 'BoutiqueController',
        ]);
    }

    /**
     * @Route("/panier/add{id}", name="boutique_add")
     */

    public function add($id,Request $request){
        $session=$request->getSession();

        $panier=$session->get('panier', []);

        $panier[$id]=1;

        $session->set('panier',$panier);

        dd($session->get('panier'));
    }
}
