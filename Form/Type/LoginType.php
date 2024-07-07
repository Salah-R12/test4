<?php
namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Form\Type\Set\ShowHidePasswordType;
use App\Form\Type\Field\TextType;

/**
 * Formulaire de connexion
 */
class LoginType extends AbstractType
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
            'csrf_token_id' => 'IZahvDe4NR470SUPEpni8TUOz4a5ol',  // Une chaîne aléatoire propre au formulaire pour augmenter la sécurité
            'last_username' => null,  // Conserve le dernier identifiant saisi
            'last_remember_me' => null,  // Conserve la valeur de la case se souvenir de moi
        ]);

        $resolver->setAllowedTypes('last_username', ['null', 'string']);
        $resolver->setAllowedTypes('last_remember_me', ['null', 'bool']);
    }

    /**
     * Construit le formulaire
     * 
     * @param FormBuilderInterface $builder Le constructeur du formulaire 
     * @param array $options Les arguments à passer si besoin 
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $options_remember_me = [
            'label' => 'login.form.remember_me',
            'required' => false,    
            'row_attr' => ['class' => 'form-group remember-me'],
        ];

        if ($options['last_remember_me'] === true) {
            $options_remember_me['attr']['checked'] = '';
        }

        $builder
            ->add('username', TextType::class, [
                'label' => 'global.username',  // désactive le label
                'data' => $options['last_username'],  // passe le dernier identifiant saisie dans la valeur de l'input
                'attr' => [
                    'autofocus' => '',  // Curseur placé directement dans le champ identifiant
                    'data-invalid-message' => $this->translator->trans('global.field_required', [    // Erreur affichée lorsque l'utilisateur ne saisie pas le champ
                        'FIELD_NAME' => $this->translator->trans('global.username')
                    ]),
                    'placeholder' => 'global.username',
                ],
            ])
            ->add('showHidePassword', ShowHidePasswordType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'login.form.submit',
                'row_attr' => ['class' => 'form-group'],
            ])
            ->add('_remember_me', CheckboxType::class, $options_remember_me);
    }
}