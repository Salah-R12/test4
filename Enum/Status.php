<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Le status d'un utilisateur
 */
enum Status: string implements TranslatableInterface {
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans('global.' . strtolower($this->name), locale: $locale);
    }
}