<?php

namespace App\Validator;

use App\Entity\User;
use App\Validator\Constraints\ExpiredUserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraint;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\LegacyPasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ExpiredUserPasswordValidator extends UserPasswordValidator
{
    private TokenStorageInterface $tokenStorage;
    private PasswordHasherFactoryInterface $hasherFactory;
    private RequestStack $requestStack;
    private EntityManagerInterface $emi;

    public function __construct(
        TokenStorageInterface $tokenStorage, 
        PasswordHasherFactoryInterface $hasherFactory,
        RequestStack $requestStack,
        EntityManagerInterface $emi
    ){
        $this->tokenStorage = $tokenStorage;
        $this->hasherFactory = $hasherFactory;
        $this->requestStack = $requestStack;
        $this->emi = $emi;
    }

    /**
     * @return void
    */
    public function validate(mixed $password, Constraint $constraint)
    {
        if (!$constraint instanceof ExpiredUserPassword) {
            throw new UnexpectedTypeException($constraint, ExpiredUserPassword::class);
        }

        if (null === $password || '' === $password) {
            $this->context->buildViolation($constraint->message)
                ->setCode(UserPassword::INVALID_PASSWORD_ERROR)
                ->addViolation();

            return;
        }

        if (!\is_string($password)) {
            throw new UnexpectedTypeException($password, 'string');
        }

        $user = $this->emi->getRepository(User::class)->find(
            $this->requestStack->getSession()->get('must_change_password_user_id')
        );
        
        if (!$user instanceof PasswordAuthenticatedUserInterface) {
            throw new ConstraintDefinitionException(sprintf('The "%s" class must implement the "%s" interface.', PasswordAuthenticatedUserInterface::class, get_debug_type($user)));
        }

        $hasher = $this->hasherFactory->getPasswordHasher($user);

        if (null === $user->getPassword() || !$hasher->verify($user->getPassword(), $password, $user instanceof LegacyPasswordAuthenticatedUserInterface ? $user->getSalt() : null)) {
            $this->context->buildViolation($constraint->message)
                ->setCode(UserPassword::INVALID_PASSWORD_ERROR)
                ->addViolation();
        }
    }
}