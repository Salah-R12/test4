<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Form\FormTypeInterface;

use App\Validator\Constraints\IsStrongPassword;

class IsStrongPasswordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsStrongPassword) {
            throw new UnexpectedTypeException($constraint, IsStrongPassword::class);
        }

        if (is_null($value)) {
            throw new InvalidArgumentException("Value can't be null.");
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $nbSpecialChar = preg_match_all('/[^A-z0-9\s]/i', $value);
        $nbCapitalizedChar = preg_match_all('/[A-Z]/', $value);
        $nbLowercaseChar = preg_match_all('/[a-z]/', $value);
        $nbDigitChar = preg_match_all('/[0-9]/', $value);

        if (
            $nbSpecialChar < 3 ||
            $nbCapitalizedChar < 3 ||
            $nbLowercaseChar < 3 ||
            $nbDigitChar < 3
        ) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}