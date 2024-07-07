<?php

// src/Service/CriteriaValidator.php

namespace App\Service;

class CriteriaValidator
{
    public function validateBirthdate(array &$criteria): void
    {
        if (!empty($criteria['birthDate'])) {
            $birthDate = $criteria['birthDate'];
            if (preg_match('/^\d{4}$/', $birthDate)) {
                // Format année (YYYY)
                $criteria['birthDate'] = [
                    'start' => strtotime("{$birthDate}-01-01 00:00:00"),
                    'end' => strtotime("{$birthDate}-12-31 23:59:59")
                ];
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $birthDate)) {
                // Format date (dd/mm/yyyy)
                $dateTime = \DateTime::createFromFormat('d/m/Y', $birthDate);
                if ($dateTime !== false) {
                    // Forcer l'heure à minuit pour le début de la journée
                    $dateTime->setTime(0, 0, 0);
                    $criteria['birthDate'] = $dateTime->getTimestamp();
                } else {
                    unset($criteria['birthDate']); // Format incorrect
                }
            } else {
                unset($criteria['birthDate']); // Format incorrect
            }
        }
    }
}
