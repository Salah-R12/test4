<?php

namespace App\Form\Type\Set;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

use App\Form\Type\Field\ImageButtonType;
use App\Form\Type\Field\PasswordType;
use App\Validator\Constraints\IsStrongPassword;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use App\Validator\Constraints as AppSecurityAssert;

/**
 * Form Type pour les champs saisies de mot de passe avec un bouton pour
 * afficher ou masquer le mot de passe
 */
class ShowHidePasswordType extends AbstractType
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
            'attr' => [
                'class' => 'form-group form-floating'
            ],
            'password_label' => 'global.password',  // désactiver le label
            'invalid_field_name' => 'global.password',  // nom du champ affiché pour l'erreur champ requis
            'check_current_password' => null,  // si vrai, on vérifie que c'est le MDP de l'utilisateur
            'check_strong_password' => null,
            'no_div' => true,
            'is_expired_password' => false,
        ]);

        $resolver->setAllowedTypes('no_div', ['null', 'bool']);
        $resolver->setAllowedTypes('password_label', ['null', 'bool', 'string']);
        $resolver->setAllowedTypes('invalid_field_name', ['null', 'string']);
        $resolver->setAllowedTypes('check_current_password', ['null', 'bool']);
        $resolver->setAllowedTypes('check_strong_password', ['null', 'bool']);
        $resolver->setAllowedTypes('is_expired_password', ['null', 'bool']);
    }

    /**
     * Construit le formulaire
     * 
     * @param FormBuilderInterface $builder Le constructeur du formulaire 
     * @param array $options Les arguments à passer si besoin 
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $options_password = [
            'label' => $options['password_label'],
            'attr' => [
                'data-invalid-message' => $this->translator->trans('global.field_required', [  // Erreur affichée lorsque l'utilisateur ne saisie pas le champ
                    'FIELD_NAME' => $this->translator->trans($options['invalid_field_name'])
                ]),
                'placeholder' => $options['password_label'],
            ],
            'no_div' => true,
            'row_attr' => ['class' => 'form-floating'],  // Utilisé que pour placer le label après l'input
        ];

        if ($options['check_current_password'] === true) {
            $options_constraint = ['message' => 'user.wrong_current_password'];
            if ($options['is_expired_password']) {
                $options_password['constraints'][] = new AppSecurityAssert\ExpiredUserPassword($options_constraint);
            } else {
                $options_password['constraints'][] = new SecurityAssert\UserPassword($options_constraint);
            }
        }

        if ($options['check_strong_password'] === true) {
            $options_password['constraints'][] = new AppSecurityAssert\IsStrongPassword();
        }

        $builder
            ->add('password', PasswordType::class, $options_password)
            ->add('showHideButton', ImageButtonType::class, [
                'button_classes' => 'toggle-password',
                'img_url' => 'images/picto/visibility.svg',
                'img_alt' => 'Afficher le mot de passe',
            ]);
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
        parent::buildView($view, $form, $options);  // On conserve le code du TextType de Symfony
        $view->vars['noDiv'] = $options['no_div'];
    }
}