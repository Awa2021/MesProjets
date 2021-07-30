<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use SessionIdInterface;


class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session,ProductRepository $productRepository)
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity){
            $panierWithData[] = [
            
            'product' => $productRepository->find($id),
            'quantity'=>$quantity  
            ];
        }

       //dd($panierWithData);
        return $this->render('cart/index.html.twig', [

            'items' => $panierWithData

        ]);

    }


    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */

    public function add($id,SessionInterface $session){
        
        $panier=$session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;

        }
        else{

        $panier[$id]=1;

        }
        $session->set('panier',$panier);
        

        return $this->redirectToRoute('cart_index');
    }
}

    

