<?php 

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

use App\Validator\AreDifferentValidator;

#[\Attribute]
class AreDifferent extends Constraint
{
    public string $message = 'user.password_must_be_different';
    public array $arrayFieldName;

    #[HasNamedArguments]
    public function __construct(array $arrayFieldName, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->arrayFieldName = $arrayFieldName ?? $this->arrayFieldName;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
    public function validatedBy(): string 
    {
        return AreDifferentValidator::class;
    }
}