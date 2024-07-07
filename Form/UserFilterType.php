<?php

// src/Form/UserFilterType.php

namespace App\Form;

use App\Service\UserFilterDataProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserFilterType extends AbstractType
{
    private $dataProvider;
    private $security;

    public function __construct(UserFilterDataProvider $dataProvider, Security $security)
    {
        $this->dataProvider = $dataProvider;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $profileTypeOptions = [
            'required' => false,
            'choices' => ['Tous' => null] + $this->dataProvider->getProfileTypes(),
            'attr' => [
                'placeholder' => 'Tous',
                'data-label' => 'Profil',
            ],
            'label' => 'Profil'
        ];

        // Si l'utilisateur a le profil 2 (TC), définir le profil par défaut et le rendre non modifiable
        if ($this->security->isGranted('ROLE_TC')) {
            $profileTypeOptions['data'] = 'ROLE_TC';
            $profileTypeOptions['disabled'] = true;
        }

        $builder
            ->add('search', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom, prénom ou email',
                    'data-label' => 'Rechercher',
                ],
                'label' => 'Rechercher'
            ])
            ->add('profileType', ChoiceType::class, $profileTypeOptions)
            ->add('status', ChoiceType::class, [
                'required' => false,
                'choices' => ['Tous' => null] + $this->dataProvider->getStatuses(),
                'attr' => [
                    'placeholder' => 'Actif',
                    'data-label' => 'Statut',
                ],
                'label' => 'Statut'
            ])
            ->add('CES', ChoiceType::class, [
                'required' => false,
                'choices' => ['Tous' => null] + $this->dataProvider->getCesChoices(),
                'attr' => [
                    'placeholder' => 'Tous',
                    'data-label' => 'CES',
                ],
                'label' => 'CES'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
