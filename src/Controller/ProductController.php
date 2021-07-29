<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Form\ProductType;



class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(ProductRepository $repo): Response
    {
        $product = $repo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $product
        ]);
    }

     
    /**
     * @Route("/product/new", name="product_new")
     */
    
    public function new(Request $request,EntityManagerInterface $em): Response
    {
        $product = new Product();
        
        $form = $this->createForm(ProductType::class,$product);
       
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            
            //recuperation de l'image depuis le formulaire
              $image = $form->get('image')->getData();
            if ($image) {
                
               
                $imageName =md5(uniqid()) . '.' .  $image->guessExtension();
            
                try {
                    //on deplace l'image dans le repertoire coverimage_directory avec le nom qu'on a creer
                    $image->move(
                        $this->getParameter('image_directory'),
                        $imageName
                    );
                } catch (FileException $e) {
                    
                }
                //on enregistre le nom de l'image dans la base de donnee
                $product->setImage($imageName);
               }
            

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_new');
            
           
        }
        return $this->render('product/create.html.twig', [
            //'product'=>$product,
            'form' => $form->createView()
        ]);
    }

   

   
}

