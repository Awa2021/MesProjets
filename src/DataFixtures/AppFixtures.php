<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i<20; $i++){

        $annonce = new Annonce();
        $annonce->setTitle(" chambre N $i");
        $annonce->setSlug("1-chambre-$i");
        $annonce->setDescription("je vous loue une chambre avec salle de bain tres neuve...");
        $annonce->setPrice(mt_rand(30000,60000));
        $annonce->setAddress("quartier");
        $annonce->setCoverImage("https:/via.placeholder.com/500*300");
        $annonce->setRooms(mt_rand(0,5));
        $annonce->setIsAvailable(mt_rand(0,1));
        $annonce->setCreatedAt( new DateTime());

        $manager->persist($annonce);    //Permet à la doctrine d'enregister l'annonce dans la BD

        $manager->flush();              //Execute l'enregistrement des données persistées
    }
}
}