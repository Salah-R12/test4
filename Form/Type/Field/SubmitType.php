<?php 

namespace App\Form\Type\Field;

use Symfony\Component\Form\Extension\Core\Type\SubmitType as SubType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form Type pour les boutton valider et possibilité de 
 * desactiver l'emboitement dans une div
 */
class SubmitType extends SubType
{
    /**
     * Configurer les options du Form Type
     * 
     * @param OptionsResolver $resolver Gère les options du formulaire
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);  // On conserve le code du SubmitType de Symfony
        $resolver->setDefaults([
            'no_div' => null,  // désactive l'emboitement dans une div
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
        parent::buildView($view, $form, $options);  // On conserve le code du SubmitType de Symfony
        $view->vars['noDiv'] = $options['no_div'];
    }
}