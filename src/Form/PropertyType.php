<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('description', null, [
                'label' => 'Déscription',
            ])
            ->add('surface', null, [
                'label' => 'Surface',
            ])
            ->add('rooms', null, [
                'label' => 'Pièces',
            ])
            ->add('bedrooms', null, [
                'label' => 'Chambre',
            ])
            ->add('floor', null, [
                'label' => 'Étage',
            ])
            ->add('price', null, [
                'label' => 'Prix',
            ])
            ->add('heat', null, [
                'label' => 'Chauffage',
            ])
            ->add('city', null, [
                'label' => 'Ville',
            ])
            ->add('address', null, [
                'label' => 'Adresse',
            ])
            ->add('postal_code', null, [
                'label' => 'Code postal',
            ])
            ->add('sold', null, [
                'label' => 'Vendu',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
