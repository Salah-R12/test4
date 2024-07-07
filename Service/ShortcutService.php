<?php

namespace App\Service;

use InvalidArgumentException;

/**
 * Fonctions bas niveau pour simplifier l'écriture du PHP
 */
class ShortcutService
{
    /**
     * Convertir du texte en camelCase à partir d'un séparateur. 
     * Converti par défaut depuis le snake_case.
     * 
     * @param string $input La chaîne en entré
     * @param string $separator Le séparateur. 
     */
    public function camelize(string $input, string $separator = '_'): string
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }

    public function checkNonNullStringForValidator(mixed $value, string $name = 'Value') 
    {
        if (is_null($value)) {
            throw new InvalidArgumentException($name . " can't be null.");
        }
        if (!is_string($value)){
            throw new InvalidArgumentException($name . " must be a string.");
        } 
    }
}