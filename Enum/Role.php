<?php

namespace App\Enum;


use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Le role d'un utilisateur
 */
enum Role: string implements TranslatableInterface  {
    case ROLE_CES = 'ROLE_CES';
    case ROLE_TC = 'ROLE_TC';
    case ROLE_EC = 'ROLE_EC';
    case ROLE_NV = 'ROLE_NV';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        $transId = $this->name === 'ROLE_CES' ? 'role_centre_examen_sante' : $this->name; 
        return $translator->trans('global.' . strtolower($transId), locale: $locale);
    }

    public function getArrayEditableRoles(): array {
        $roles_choices = [];
        switch ($this) {
            case Role::ROLE_EC: 
                $roles_choices = [Role::ROLE_CES, Role::ROLE_EC, Role::ROLE_NV];
                break;
            case Role::ROLE_TC: 
                $roles_choices = [ROLE::ROLE_TC];
                break;
        }
        return $roles_choices;
    }
}