<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * Undocumented variable
     *
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {   
        $this->repository = $repository;
    }

    /**
     * liste les biens
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // POUR CONSULTER LA BDD
        // récup la première propriété
        $property = $this->repository->findAllVisible();
        dump($property);

        // POUR ENVOYER VERS LA BDD
        // $property = $repository->find($id);

        // $entityManager = $doctrine->getManager();

        // $property = new Property();
        // $property->setTitle('Mon premier bien')
        //     ->setPrice(200000)
        //     ->setRooms(4)
        //     ->setBedrooms(3)
        //     ->setDescription('Une petite description')
        //     ->setSurface(60)
        //     ->setFloor(4)
        //     ->setHeat(1)
        //     ->setCity('Angers')
        //     ->setAddress('15 Boulevard Gambetta')
        //     ->setPostalCode(34000);
            
        // // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $entityManager->persist($property);

        // // actually executes the queries (i.e. the INSERT query)
        // $entityManager->flush();

        return $this->render('property/index.html.twig',[
            'current_menu'=>'properties' 
        ]); 
    }
}