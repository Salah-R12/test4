<?php 

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

use App\Validator\EntryMustExistsValidator;

#[\Attribute]
class EntryMustExists extends Constraint
{
    public string $message = "global.field_doesnt_exists_in_base";
    public ?string $entityClassName = null;
    public ?string $property = null;

    public function __construct(?string $entityClassName, ?string $property, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->entityClassName = $entityClassName ?? $this->entityClassName;
        $this->property = $property ?? $this->property;
    }

    public function validatedBy(): string 
    {
        return EntryMustExistsValidator::class;
    }
}