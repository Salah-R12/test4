<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Form\FormTypeInterface;

use App\Validator\Constraints\AreDifferent;

class AreDifferentValidator extends ConstraintValidator
{
    protected function getValue($fieldname) 
    {
        $fieldname = explode('.', $fieldname);
        $value = $this->context->getRoot()->get(array_shift($fieldname));
        foreach ($fieldname as $child) {
            $value = $value->get($child);
        }
        return $value->getData();
    }

    public function validate(mixed $_form, Constraint $constraint): void
    {
        if (!$constraint instanceof AreDifferent) {
            throw new UnexpectedTypeException($constraint, AreDifferent::class);
        }

        if (is_null($_form) || empty($_form)) {
            return;
        }

        if ($_form instanceof FormTypeInterface) {
            throw new UnexpectedValueException($_form, 'FormTypeInterface');
        }

        $arrayFieldName = $constraint->arrayFieldName;
        $arrayValue = array_map([$this, "getValue"], $arrayFieldName);
        foreach (array_count_values($arrayValue) as $value) {
            if ($value > 1) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}