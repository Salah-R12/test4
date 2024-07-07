<?php

namespace App\Form\Type\Field;

use App\Service\ShortcutService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Bouton avec image
 */
class ImageButtonType extends AbstractType
{
    protected $arrayStringType = [
        'img_alt',  // attribut "alt" de l'image
        'img_url',  // attribut "href" de l'image
        'button_classes',  // attribut "src" de l'image
    ];

    protected ShortcutService $shortcut;
    
    public function __construct(ShortcutService $shortcut)
    {
        $this->shortcut = $shortcut;
    }

    /**
     * Configurer les options du Form Type
     * 
     * @param OptionsResolver $resolver Gère les options du formulaire
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array_flip($this->arrayStringType));

        foreach ($this->arrayStringType as $stringType) {
            $resolver->setAllowedTypes($stringType, ['null', 'string']);
        }
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
        foreach ($this->arrayStringType as $stringType) {
            $view->vars[$this->shortcut->camelize($stringType)] = $options[$stringType];
        }
    }
}