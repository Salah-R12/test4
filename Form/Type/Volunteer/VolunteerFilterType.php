<?php
// src/Form/VolunteerFilterType.php

namespace App\Form\Type\Volunteer;


use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolunteerFilterType extends AbstractType
{


    public function __construct(){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom ou numéro Constance',
                    'data-label' => 'Rechercher',
                ],
                'label' => 'Rechercher'
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'data-label' => 'Prénom',
                ],
                'label' => 'Prénom'
            ])
            ->add('birthDate', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'YYYY ou DD/MM/YYYY',
                ],
                'label' => 'Date de Naissance',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
