<?php

// src/Service/UserFilterDataProvider.php

namespace App\Service;

use App\Repository\RefCesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserFilterDataProvider
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager,RefCesRepository $refCesRepository)
    {
        $this->refCesRepository = $refCesRepository;
        $this->entityManager = $entityManager;
    }

    public function getProfileTypes(): array
    {
        $roles = $this->entityManager->createQueryBuilder()
            ->select('u.roles')
            ->from(User::class, 'u')
            ->distinct()
            ->getQuery()
            ->getArrayResult();

        $roleChoices = [];
        foreach ($roles as $role) {
            foreach ($role['roles'] as $r) {
                $formattedRole = $this->formatRole($r);
                $roleChoices[$formattedRole] = $r; // Clé pour l'affichage, valeur pour la soumission
            }
        }

        return array_unique($roleChoices);
    }

    public function getStatuses(): array
    {
        return [
            'Actif' => 'Active',
            'Inactif' => 'Inactive'
        ];
    }

    public function getCesChoices(): array
    {
        $cesEntities = $this->refCesRepository->findAll();
        $choices = [];
        foreach ($cesEntities as $ces) {
            $choices[$ces->getTitle()] = $ces->getTitle();
        }
        return $choices;
    }

    // Supprime le préfixe "ROLE_" de chaque mot
    public function formatRole(string $role): string
    {
        // Supprime le préfixe "ROLE_" et capitalise chaque mot
        $roleWithoutPrefix = str_replace('ROLE_', '', $role);
        return ucwords(strtolower(str_replace('_', ' ', $roleWithoutPrefix)));
    }

    // Méthode pour revenir au rôle avec le préfixe "ROLE_" (de "Ces" à "ROLE_CES"
    public function unformatRole(string $formattedRole): string
    {
        $roleWithUnderscores = strtoupper(str_replace(' ', '_', $formattedRole));
        return 'ROLE_' . $roleWithUnderscores;
    }
}
