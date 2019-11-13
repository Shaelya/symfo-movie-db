<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_list")
     */
    public function index()
    {

        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/movies/{movie}/details", name="movie_single_details")
     */
    public function singleMovie(Movie $movie)
    {

        return $this->render('movie/single.html.twig', [
            'movie' => $movie,
        ]);
    }
}
