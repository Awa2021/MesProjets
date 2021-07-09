<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Annonce;
use App\Entity\Comment;
use App\Form\AnnonceType;
use App\Form\CommentType;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Respnse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


Class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'annonce')]
    public function index(AnnonceRepository $repo): Response
    {
        $annonces = $repo->findAll();
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    #[Route('/anounce/{id}', name: 'annonce_show')]
    public function show(AnnonceRepository $repo,int $id,Request $request,EntityManagerInterface $em): Response
    {
        $annonce = $repo->find($id);
        $comment = new Comment();
        
        $form = $this->createForm(CommentType::class,$comment);
       
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            $comment->setCreatedAt(new \Datetime());
            $comment->setAnnonce($annonce);
            //recuperation de l'image depuis le formulaire
              
            

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('annonce_show',['id'=>$annonce->getId()]);
             
    }
    return $this->render('annonce/show.html.twig', [
        'annonce'=>$annonce,
        'form' => $form->createView()
    ]);
}
       
    #[Route('/annonce/create', name: 'annonce_create')]
    public function Create(Request $request,EntityManagerInterface $em): Response
    {
        $annonce = new Annonce();
        
        $form = $this->createForm(AnnonceType::class,$annonce);
       
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            $annonce->setCreatedAt(new \Datetime());
            //recuperation de l'image depuis le formulaire
              $coverImage = $form->get('coverImage')->getData();
            if ($coverImage) {
                
               
                $imageName =md5(uniqid()) . '.' .  $coverImage->guessExtension();
            
                try {
                    //on deplace l'image dans le repertoire coverimage_directory avec le nom qu'on a creer
                    $coverImage->move(
                        $this->getParameter('coverImage_directory'),
                        $imageName
                    );
                } catch (FileException $e) {
                    
                }
                //on enregistre le nom de l'image dans la base de donnee
                $annonce->setCoverImage($imageName);
               }
            

            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce');
            
           
        }
        return $this->render('annonce/create.html.twig', [
            'annonce'=>$annonce,
            'form' => $form->createView()
        ]);
    }

    #[Route('/annonce/edit/{id}', name: 'annonce_edit')]
    public function Edit(Annonce $annonce,Request $request,EntityManagerInterface $em): Response
    {
       
        $form = $this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){

            $annonce->setCreatedAt(new \Datetime());
            //recuperation de l'image depuis le formulaire
              $coverImage = $form->get('coverImage')->getData();
            if ($coverImage) {
                
               
                $imageName =md5(uniqid()) . '.' .  $coverImage->guessExtension();
            
                try {
                    //on deplace l'image dans le repertoire coverimage_directory avec le nom qu'on a creer
                    $coverImage->move(
                        $this->getParameter('coverImage_directory'),
                        $imageName
                    );
                } catch (FileException $e) {
                    
                }
                //on enregistre le nom de l'image dans la base de donnee
                $annonce->setCoverImage($imageName);
               }
            

            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce');
           
        }
        return $this->render('annonce/edit.html.twig', [
            'annonce'=>$annonce,
            'form' => $form->createView()
        ]);
    }

    #[Route('/annonce/delete/{id}', name: 'annonce_delete')]
    public function delete(EntityManagerInterface $em, Annonce $annonce): Response
    {
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('annonce');
    }

    
       
}
