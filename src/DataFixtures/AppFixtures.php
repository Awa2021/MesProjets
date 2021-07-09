<?php

namespace App\DataFixtures;


use App\Entity\Annonce;
use App\Entity\Comment;
use App\Entity\Image;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
   
        $faker= Factory::create('fr,FR');
     $slugger = new Slugify();
        for ($i = 0; $i<20; $i++){

        $annonce = new Annonce();
        $annonce->setTitle($faker->sentence(3));
        $annonce->setIntroduction($faker->sentence());
      //  $annonce->setSlug($slugger->slugify($annonce->getTitle()));
        $annonce->setDescription($faker->text(500));
        $annonce->setPrice(mt_rand(30000,60000));
        $annonce->setAddress($faker->address);
        $annonce->setCoverImage("MonImage.jpg");
        $annonce->setRooms(mt_rand(0,5));
        $annonce->setIsAvailable(mt_rand(0,1));
        $annonce->setCreatedAt( $faker->dateTimeBetween('-3 month','now'));

        for ($j = 0; $j<mt_rand(0,7); $j++) {
            $comment = new Comment();
            $comment->setAuthor($faker->name(200)) 
                    ->setEmail($faker->email())
                    ->setContent($faker->text())
                    ->setCreatedAt( $faker->dateTimeBetween('-3 month','now'))
                    ->setAnnonce($annonce);
                   // $manager->persist($comment);
                    $annonce->addComment($comment);
        }

        for ($k = 0; $k<mt_rand(0,4); $k++) {
            $image=new Image();
            $image->setImageUrl(("https://picsum.photos/1024/500?random=".mt_rand(1,5000)))
                ->setDescription($faker->text())
                ->setAnnonce($annonce);
              //  $manager->persist($image);
                $annonce->addImage($image);
        }
                    
        $manager->persist($annonce);    //Permet à la doctrine d'enregister l'annonce dans la BD
    
        $manager->flush();              //Execute l'enregistrement des données persistées
    }
}
    
}