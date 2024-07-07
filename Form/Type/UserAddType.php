<?php

namespace App\Form\Type;

use App\Entity\RefCes;
use App\Entity\User;
use App\Enum\Role;
use App\Form\Type\Field\EnumType;
use App\Form\Type\Field\TextType;
use App\Form\Type\Set\ValidateCancelType;
use App\Form\Type\Field\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserAddType extends AbstractType
{
    protected TranslatorInterface $translator;
    protected EntityManagerInterface $emi;
    protected Security $security;

    public function __construct(TranslatorInterface $translator, EntityManagerInterface $emi, Security $security)
    {
        $this->translator = $translator;
        $this->emi = $emi;
        $this->security = $security;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => 'csrf_token',
            'csrf_token_id' => 'jyLlcuyZIVscxgieqcpckBd9byl0wjT3',
            'data_class' => User::class,
            'roles_choices' => [],
            'roles_placeholder' => 'global.choose_value',
            'is_tc' => false, // Ajouter cette option
        ]);

        $resolver->addAllowedTypes('roles_choices', ['array']);
        $resolver->addAllowedTypes('roles_placeholder', ['null', 'string']);
        $resolver->addAllowedTypes('is_tc', ['bool']); // Ajouter le type permis pour is_tc
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $rolesFieldOptions = [
            'class' => Role::class,
            'label' => 'global.role',
            'choices' => $options['roles_choices'],
            'row_attr' => ['class' => 'form-group user-roles label-in-border'],
            'attr' => [
                'data-invalid-message' => $this->translator->trans('global.field_required', [
                    'FIELD_NAME' => $this->translator->trans('global.role')
                ]),
            ],
            'required' => true,
            'placeholder' => $options['roles_placeholder'],
            'constraints' => [
                new NotBlank([
                    'message' => $this->translator->trans('global.field_required', [
                        'FIELD_NAME' => $this->translator->trans('global.role')
                    ]),
                ]),
            ],
        ];

        if ($options['is_tc']) {
            $rolesFieldOptions['data'] = Role::ROLE_TC;
            $rolesFieldOptions['disabled'] = true;
        }

        $builder
            ->add('lastname', TextType::class, [
                'label' => 'global.lastname',
                'required' => true,
                'attr' => [
                    'placeholder' => 'global.lastname',
                    'data-invalid-message' => $this->translator->trans('global.field_required', [
                        'FIELD_NAME' => $this->translator->trans('global.lastname')
                    ]),
                    "class" => "bg-transparent border border-primary"
                ],
                'row_attr' => [
                    'class' => 'col form-group form-floating'
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'global.firstname',
                'required' => true,
                'attr' => [
                    'placeholder' => 'global.firstname',
                    'data-invalid-message' => $this->translator->trans('global.field_required', [
                        'FIELD_NAME' => $this->translator->trans('global.firstname')
                    ]),
                    "class" => "bg-transparent border border-primary",
                ],
                'row_attr' => [
                    'class' => 'col form-group form-floating'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'global.email',
                'help' => 'user_manage.user_modal_email_description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'global.email',
                    'data-invalid-message' => $this->translator->trans('global.field_required', [
                        'FIELD_NAME' => $this->translator->trans('global.email')
                    ]),
                    "class" => "bg-transparent border border-primary"
                ],
                'constraints' => [
                    new Email([
                        'message' => 'global.invalid_email',
                    ]),
                ],
            ])
            ->add('roles', EnumType::class, $rolesFieldOptions)
            ->add('ces', EntityType::class, [
                'label' => 'global.ces',
                'class' => RefCes::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('ces')->orderBy('ces.title', 'ASC');
                },
                'attr' => [
                    'data-invalid-message' => $this->translator->trans('global.field_required', [
                        'FIELD_NAME' => $this->translator->trans('global.ces')
                    ]),
                ],
                'choice_label' => 'title',
                'row_attr' => ['class' => 'form-group user-ces label-in-border'],
            ])
            ->add('validateCancel', ValidateCancelType::class, [
                'row_attr' => ['class' => 'form-group validate-cancel'],
                'mapped' => false,
                'do_not_submit' => true,
            ]);

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            function($roles): ?Role {
                if (is_array($roles) && !empty($roles)) {
                    return Role::from($roles[0]);
                }
                return $roles; // If it's already a Role object, return it as is
            },
            function(?Role $role): ?array {
                return $role ? [$role->value] : [];
            }
        ));
    }
}
