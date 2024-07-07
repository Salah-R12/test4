<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Doctrine\ORM\EntityManagerInterface;

use App\Service\ShortcutService;
use App\Validator\Constraints\EntryMustExists;

class EntryMustExistsValidator extends ConstraintValidator
{
    protected EntityManagerInterface $emi;
    protected ShortcutService $shortcut;

    public function __construct(EntityManagerInterface $emi, ShortcutService $shortcut)
    {
        $this->emi = $emi;
        $this->shortcut = $shortcut;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntryMustExists) {
            throw new UnexpectedTypeException($constraint, EntryMustExists::class);
        }

        $entityClassName = $constraint->entityClassName;
        $property = $constraint->property;

        $this->shortcut->checkNonNullStringForValidator($entityClassName, 'Entity class name');
        
        if (!class_exists($entityClassName)) {
            throw new InvalidArgumentException("Entity class name doesn't exists. '" . $entityClassName . "' given");
        }

        $this->shortcut->checkNonNullStringForValidator($property, 'Property');
        $this->shortcut->checkNonNullStringForValidator($value);
        
        $match = $this->emi->getRepository($entityClassName)->findOneBy([$property => $value]);

        if (is_null($match)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}