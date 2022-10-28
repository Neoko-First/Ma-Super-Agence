<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * Injection du repository concernant les propriétés pour accéder aux infos 
     *
     * @param PropertyRepository $repository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {
        // recup des infos des propriétés
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     */
    public function edit(Property $property)
    {
        $form = $this->createForm(PropertyType::class, $property);
        return $this->render('admin/property/edit.html.twig', ['property' => $property, 'form' => $form->createView()]);
    }
}
