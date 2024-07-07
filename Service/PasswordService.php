<?php

namespace App\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use App\Entity\User;
use App\Enum\Status;
use DateInterval;

/**
 * Fonctions bas niveau pour simplifier l'écriture du PHP
 */
class PasswordService
{
    protected UserPasswordHasherInterface $passwordHasher;
    protected EntityManagerInterface $emi;
    protected EmailSenderService $ess;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $emi,
        EmailSenderService $ess,
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->emi = $emi;
        $this->ess = $ess;
    }

    /**
     * Hash le mot de passe
     * 
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur concerné
     * @param string $password Le mot de passe en clair
     */
    public function hashPassword(PasswordAuthenticatedUserInterface $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    /**
     * Modifier le mot de passe d'un utilisateur
     * 
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur concerné
     * @param string $newPassword Le nouveau mot de passe
     */
    public function changePassword(
        PasswordAuthenticatedUserInterface $user, 
        string $newPassword,
        bool $mustChangePassword
    ): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));
        $user->setPasswordLastChange(new DateTime());
        $user->setMustChangePassword($mustChangePassword);
        $this->emi->persist($user);
        $this->emi->flush();
    }

    /**
     * Modifier le mot de passe d'un utilisateur
     * 
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur concerné
     */
    public function generatePassword(PasswordAuthenticatedUserInterface $user): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $combMin = str_shuffle(implode(range('a', 'z')));
        $combMaj = str_shuffle(implode(range('A', 'Z')));
        $combChi = str_shuffle(implode(range('0', '9')));
        $combSpe = str_shuffle(",?;.:!§*-+<>{}=][");
        $pwd = str_shuffle(substr($combMin,0,3) . substr($combMaj,0,3) . substr($combChi,0,3) . substr($combSpe, 0,3));
        $this->ess->sendPasswordMail($user, $pwd);
        $user->setMustChangePassword(true);
        $this->changePassword($user, $pwd, true);
    }

    /**
     * Savoir si le mot de passe de l'utilisateur a expiré
     * 
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur concerné
     */
    public function isPasswordExpired(PasswordAuthenticatedUserInterface $user): mixed
    {
        $allowedDaysAfterLastChange = 6 * 30;  // 6 mois en jours
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $passwordLastChangeDateTime = $user->getPasswordLastChange();

        if (is_null($passwordLastChangeDateTime)){
            return true;
        }

        $dateIntervalElapsed = (new DateTime())->diff($passwordLastChangeDateTime);
        return $dateIntervalElapsed->days > $allowedDaysAfterLastChange;
    }
}