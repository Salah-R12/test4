<?php

namespace App\Form\Type;

use App\Enum\Status;
use App\Form\Type\Field\SwitchType;
use App\Form\Type\Field\TextType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserEditType extends UserAddType
{
    protected TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $parentOptions = $options;
        $parentOptions['roles_placeholder'] = null;
        parent::buildForm($builder, $parentOptions);

        $builder->remove('ces');

        $builder->add('ces', TextType::class, [
            'label' => 'global.ces',
            'disabled' => true,
            'row_attr' => ['class' => 'form-group user-ces label-in-border'],
        ]);

        $builder->add('status', SwitchType::class, [
            'label' => false,
            'attr' => [
                'role' => 'switch',
                'data-yes-label' => $this->translator->trans('global.active'),
                'data-no-label' => $this->translator->trans('global.inactive'),
            ],
            'no_div' => true,
        ]);
        $builder->get('status')->addModelTransformer(new CallbackTransformer(
            function(mixed $status): mixed {  // Status to Boolean
                return ($status == Status::ACTIVE);
            },
            function(mixed $status): mixed {  // Boolean to Status
                return $status == "1" ? Status::ACTIVE : Status::INACTIVE;
            }
        ));
    }
}
