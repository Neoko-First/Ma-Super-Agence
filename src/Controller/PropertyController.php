<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * Undocumented variable
     *
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {   
        $this->repository = $repository;
        // pour manipuler la bdd
        $this->em = $em;
    }

    /**
     * liste les biens
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response
    {
        // POUR CONSULTER LA BDD
        // récup les propriétés dispo
        $properties = $this->repository->findAllVisible();
        // modifier la bdd
        dump($properties);
        // flush detecte 
        // $property[0]->setSold(true);
        // $this->em->flush();

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

    /**
     * Undocumented function
     *
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show($slug, $id): Response
    {
        $property = $this->repository->find($id);
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu'=>'properties' 
        ]); 
    }
}