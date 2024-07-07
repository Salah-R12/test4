<?php 

namespace App\Form\Type\Field;

use Symfony\Bridge\Doctrine\Form\Type\EntityType as EntitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form Type pour les champs Entity avec label flottant et possibilité de 
 * desactiver l'emboitement dans une div
 */
class EntityType extends EntitType
{
    /**
     * Configurer les options du Form Type
     * 
     * @param OptionsResolver $resolver Gère les options du formulaire
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);  // On conserve le code de l'Entity Type de Symfony
        $resolver->setDefaults([
            'no_div' => null,  // désactive l'emboitement dans une div
            'row_attr' => [
                'class' => 'form-group form-floating'
            ],
        ]);

        $resolver->setAllowedTypes('no_div', ['null', 'bool']);
    }

    /**
     * Passer les options du Form Type dans le Twig
     * 
     * @param FormView $view Représente la Vue Twig du Form Type
     * @param FormInterface $form Représente le Form Type en PHP
     * @param array $options Les options du Form Type
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);  // On conserve le code de l'Entity Type de Symfony
        $view->vars['noDiv'] = $options['no_div'];
    }
}