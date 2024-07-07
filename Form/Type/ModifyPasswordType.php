<?php
namespace App\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use App\Form\Type\Set\ShowHidePasswordType;
use App\Form\Type\Set\ValidateCancelType;
use App\Validator\Constraints as Constraints;
use App\Validator\Constraints\AreDifferent;

/**
 * Formulaire de connexion
 */
#[Constraints\AreDifferent()]
class ModifyPasswordType extends AbstractType
{

    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Active l'option du formulaire pour la protection CSRF
     * 
     * @param OptionsResolver $resolver Gère les options du formulaire
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,  // Active la protection CSRF
            'csrf_field_name' => 'csrf_token',  // Nom du champ caché qui contient le token CSRF 
            'csrf_token_id' => 'jyLlcuyZIVscxgieqcpckBd9byl0wjT3',  // Une chaîne aléatoire propre au formulaire pour augmenter la sécurité
            'constraints' => [
                new AreDifferent([
                    'oldPassword.password',
                    'newPassword.first.password',
                ])
            ],
            'is_expired_password' => false,
        ]);

        $resolver->addAllowedTypes('is_expired_password', ['null', 'bool']);
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
            ->add('oldPassword', ShowHidePasswordType::class, [
                'check_current_password' => true,
                'password_label' => 'user.old_password',
                'is_expired_password' => $options['is_expired_password'],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => ShowHidePasswordType::class,
                'invalid_message' => 'user.password_are_different',
                'options' => [
                    'attr' => [
                        'data-invalid-message' => $this->translator->trans('global.field_required', [  
                            'FIELD_NAME' => $this->translator->trans('user.new_password'),
                        ]),
                        'class' => 'form-group form-floating'
                    ],
                    'password_label' => 'user.new_password',
                    'invalid_field_name' => 'user.new_password',  // nom du champ affiché pour l'erreur champ requis
                ],
                'first_options' => [
                    'check_strong_password' => true,
                ],
                'required' => true,
            ])
            ->add('validateCancel', ValidateCancelType::class, [
                'row_attr' => ['class' => 'form-group validate-cancel'],
            ]);
    }
}