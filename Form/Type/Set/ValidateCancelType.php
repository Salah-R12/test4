<?php

namespace App\Form\Type\Set;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Form\Type\Field\SubmitType;
use App\Form\Type\Field\ButtonType;

/**
 * Form Type pour les champs saisies de mot de passe avec un bouton pour
 * afficher ou masquer le mot de passe
 */
class ValidateCancelType extends AbstractType
{   

    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Configurer les options du Form Type
     * 
     * @param OptionsResolver $resolver Gère les options du formulaire
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,  // désactiver le label
            'placeholder' => 'global.password',
            'invalid_field_name' => 'global.password',  // nom du champ affiché pour l'erreur champ requis
            'do_not_submit' => false,  // Ne pas soumettre formulaire. Utile pour utiliser Fetch API...  
        ]);

        $resolver->setAllowedTypes('placeholder', ['null', 'string']);
        $resolver->setAllowedTypes('invalid_field_name', ['null', 'string']); 
        $resolver->setAllowedTypes('do_not_submit', ['null', 'bool']); 
    }

    /**
     * Construit le formulaire
     * 
     * @param FormBuilderInterface $builder Le constructeur du formulaire 
     * @param array $options Les arguments à passer si besoin 
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cancel', ButtonType::class, [
                'label' => 'global.cancel',
                'no_div' => true,
                'attr' => [
                    'class' => "btn btn-outline-primary",
                    'data-bs-dismiss' => "modal",
                ]
            ])
            ->add('submit', $options['do_not_submit'] ? ButtonType::class : SubmitType::class, [
                'label' => 'global.validate',
                'no_div' => true,
                'attr' => [
                    'class' => "btn btn-primary",
                ]
            ]);
    }
}

