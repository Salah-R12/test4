<?php 

namespace App\Validator\Constraints;

use App\Validator\ExpiredUserPasswordValidator;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

#[\Attribute]
class ExpiredUserPassword extends UserPassword
{
    public function validatedBy(): string 
    {
        return ExpiredUserPasswordValidator::class;
    }
}