<?php
namespace App\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;
use App\Form\Type\Set\ValidateCancelType;
use App\Form\Type\Field\TextType;
use App\Validator\Constraints\EntryMustExists;

/**
 * Formulaire de connexion
 */
class ForgotPasswordType extends AbstractType
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
        ]);
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
            ->add('username', TextType::class, [
                'row_attr' => ['class' => 'form-group'],
                'label' => false,
                'attr' => [
                    'placeholder' => 'global.username',
                ],
                'constraints' => [
                    new EntryMustExists(User::class, 'email', 'user.unknown_username_please_contact_constances')
                ],
            ])
            ->add('validateCancel', ValidateCancelType::class, [
                'row_attr' => ['class' => 'form-group validate-cancel'],
            ]);
    }
}