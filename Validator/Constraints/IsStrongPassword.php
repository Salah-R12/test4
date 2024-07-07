<?php 

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

use App\Validator\IsStrongPasswordValidator;

#[\Attribute]
class IsStrongPassword extends Constraint
{
    public string $message = 'user.password_must_be_strong';

    public function __construct(?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string 
    {
        return IsStrongPasswordValidator::class;
    }
}