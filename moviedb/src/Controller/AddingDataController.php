<?php

namespace App\Controller;

use App\Entity\Casting;
use App\Entity\Movie;
use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AddingDataController extends AbstractController
{
    /**
     * @Route("/add/casting", name="adding_data_casting")
     */
    public function addCasting()
    {
        // On a pas encore de personnes ou de films, il faut en créer

        $em = $this->getDoctrine()->getManager();

        // Création de deux Person
        $leonardo = new Person();
        $leonardo->setName('Leonardo DiCaprio');
        $em->persist($leonardo);

        $brad = new Person();
        $brad->setName('Brad Pitt');
        $em->persist($brad);
        

        // Création d'un Movie
        $newMovie = new Movie();
        $newMovie->setTitle('Once upon a time... in Hollywood');
        $em->persist($newMovie);


        // Création des deux Casting qui relient ces entités
        // le casting de Leonardo
        $castingL = new Casting();
        $castingL->setRole('Rick Dalton');
        $castingL->setCreditOrder(1);
        $castingL->setPerson($leonardo);
        $castingL->setMovie($newMovie);
        $em->persist($castingL);

        // le casting de Brad
        $castingB = new Casting();
        $castingB->setRole('Cliff Booth');
        $castingB->setCreditOrder(2);
        $castingB->setPerson($brad);
        $castingB->setMovie($newMovie);
        $em->persist($castingB);

        // On flush tous nos objets
        $em->flush();


        return $this->json('Once upon a time in Hollywood, objects were created, persisted ans flushed');
    }
}
