<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * Injection du repository concernant les propriétés pour accéder aux infos 
     *
     * @var PropertyRepository $repository
     */
    private $repository;
    /**
     * Permet la manipulation des propriétés
     *
     * @param ObjectManager $em
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Indexation des biens
     * 
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        // recup des infos des propriétés
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * Création d'un bien
     *
     * @Route("admin/property/create", name="admin.property.new")
     * 
     */
    public function new(Request $request)
    {
        // nouvel objet propriété
        $property = new Property();
        // crée un formulaire
        $form = $this->createForm(PropertyType::class, $property);
        // déini les champs du formulaire 
        $form->handleRequest($request);

        // si formulaire envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // faire persister cette nouvelle entité
            $this->em->persist($property);
            // envoi vers la bdd 
            $this->em->flush();
            // feedback user
            $this->addFlash('success', 'Bien crée avec succés');
            // redirige
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification d'un bien
     * 
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * 
     */
    public function edit(Property $property, Request $request)
    {
        // crée un formulaire
        $form = $this->createForm(PropertyType::class, $property);
        // déini les champs du formulaire 
        $form->handleRequest($request);

        // si formulaire envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // envoi vers la bdd 
            $this->em->flush();
            // feedback user
            $this->addFlash('success', 'Bien modifié avec succés');
            // redirige
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * Suppression d'un bien
     * 
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * 
     */
    public function delete(Property $property, Request $request)
    {
        // verrification du token csrf pour empécher la création de form injéctés
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            // retire le bien de l'entity manager
            $this->em->remove($property);
            // porte les infos en BDD
            $this->em->flush();
            // feedback user
            $this->addFlash('success', 'Bien supprimé avec succés');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}
