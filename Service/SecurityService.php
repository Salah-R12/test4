<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Enum\Status;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Fonctions bas niveau pour simplifier l'écriture du PHP
 */
class SecurityService
{
    protected RequestStack $requestStack;

    public function __construct( RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }

    /**
     * Forcer la déconnexion de l'utilisateur
     */
    protected function invalidateSessions(User $user): void 
    {
        $key_pattern = '/([_\w\d]+)\|/';
        foreach (glob(session_save_path() . '*') as $session) {
            $filename = basename($session);
            if ($this->requestStack->getSession()->getId() === substr($filename, 5)) {
                continue;  // Ignorer la session courante car elle ne peut pas être lu
            }
            if (substr($filename, 0, 5) !== 'sess_') {
                continue;  // Ignorer les fichiers qui ne sont pas des sessions
            }
            $session_content = file_get_contents($session);

            if ($session_content == '') {
                continue;  // Ignorer les sessions vides
            }
            $array_exploded = [];
            foreach (explode('|', $session_content) as $data) {
                $array_exploded[] = $data . '|'; 
            }
            $array_key_value = [substr($array_exploded[0], 0, -1) => preg_replace($key_pattern, '', $array_exploded[1])];
            for ($i=1; $i < count($array_exploded) - 1; $i++) {
                $str_value_key = $array_exploded[$i];
                preg_match($key_pattern, $str_value_key, $match);
                $array_key_value[substr($match[1], 0, -1)] = preg_replace($key_pattern, '', $str_value_key); 
            }
            $array_key_value = array_map(fn ($value) => $value = unserialize($value), $array_key_value);
            $usernamePasswordToken = unserialize($array_key_value['_sf2_attributes']['_security_main'] ?? '');
            $userId = $usernamePasswordToken ? $usernamePasswordToken->getUser()->getId() : '';
            
            if ($user->getId() == $userId) {
                unlink($session);
            }
        }
    }

    /**
     * Désactive l'utilisateur, rendre son status Inactif et le deconnecter
     * 
     * @param User $user L'utilisateur concerné
     */
    public function deactivateUser(User $user): void
    {
        $user->setStatus(Status::INACTIVE);
        $this->invalidateSessions($user);
    }
}