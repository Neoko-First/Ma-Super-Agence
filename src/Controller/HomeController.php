<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    /**
     * afficher la page d'accueil => renvoi toujours une réponse 
     * @Route("/", name="home") 
     * @return Response
     */
    public function index(PropertyRepository $repository): Response{
        $this->repository = $repository;
        $properties = $this->repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
 
}

