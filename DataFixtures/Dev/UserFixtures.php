<?php

// src/DataFixtures/Dev/UserFixtures.php

namespace App\DataFixtures\Dev;

use App\Entity\User;
use App\Entity\RefCes;
use App\Enum\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Utilisateurs de base avec les conditions spécifiées
        $profiles = [
            [
                'email' => 'ces_user@example.com',
                'role' => 'ROLE_CES',
                'status' => Status::ACTIVE,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'mustChangePassword' => false,
            ],
            [
                'email' => 'tc_user@example.com',
                'role' => 'ROLE_TC',
                'status' => Status::ACTIVE,
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'mustChangePassword' => false,
            ],
            [
                'email' => 'constances_user@example.com',
                'role' => 'ROLE_EC',
                'status' => Status::ACTIVE,
                'firstname' => 'Alice',
                'lastname' => 'Johnson',
                'mustChangePassword' => false,
            ],
            [
                'email' => 'nvert_user@example.com',
                'role' => 'ROLE_NV',
                'status' => Status::ACTIVE,
                'firstname' => 'Bob',
                'lastname' => 'Brown',
                'mustChangePassword' => false,
            ],
        ];

        // Rôles disponibles
        $roles = ['ROLE_CES', 'ROLE_EC', 'ROLE_NV'];

        // Ajout de 30 utilisateurs supplémentaires de type TC
        for ($i = 0; $i < 30; $i++) {
            $profiles[] = [
                'email' => 'role_tc_user' . $i . '@example.com',
                'role' => 'ROLE_TC',
                'status' => Status::ACTIVE,
                'firstname' => 'GeneratedFirstName' . $i,
                'lastname' => 'GeneratedLastName' . $i,
                'mustChangePassword' => false,
            ];
        }

        // Ajout de 30 utilisateurs supplémentaires pour d'autres rôles
        for ($i = 30; $i < 60; $i++) {
            $role = $roles[array_rand($roles)];
            $profiles[] = [
                'email' => strtolower($role) . "_user$i@example.com",
                'role' => $role,
                'status' => (rand(0, 1) == 1) ? Status::ACTIVE : Status::INACTIVE,
                'firstname' => 'GeneratedFirstName' . $i,
                'lastname' => 'GeneratedLastName' . $i,
                'mustChangePassword' => rand(0, 1) == 1,
            ];
        }

        foreach ($profiles as $index => $profile) {
            $user = new User();
            $user->setEmail($profile['email']);
            $user->setRoles([$profile['role']]);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'SALAHsalah123%%%1'));
            $user->setStatus($profile['status']);
            $user->setFirstname($profile['firstname']);
            $user->setLastname($profile['lastname']);
            $user->setMustChangePassword($profile['mustChangePassword']);

            // Assigner un ces_id à chaque utilisateur
            $refCes = $this->getReference('ref_ces_' . array_rand([0, 1])); // Choisir un ref_ces aléatoire
            $user->setCes($refCes);

            $manager->persist($user);

            // Stockez la référence pour l'utiliser dans d'autres fixtures
            $this->addReference('user_' . $index, $user);
        }

        // Enregistrer tous les utilisateurs dans la base de données
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RefSiteFixtures::class,
        ];
    }
}
