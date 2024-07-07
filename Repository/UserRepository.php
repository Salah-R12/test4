<?php
// src/Repository/UserRepository.php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $hasher)
    {
        parent::__construct($registry, User::class);
        $this->hasher = $hasher;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findUsersWithFilters(array $criteria = [], array $userRoles = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->leftJoin('u.ces', 'ces')
            ->addSelect('ces');

        // Application des règles de gestion en fonction des rôles
        if (in_array('ROLE_TC', $userRoles)) {
            $queryBuilder->where('u.roles LIKE :role')
                ->setParameter('role', '%"ROLE_TC"%');
            $queryBuilder->orderBy('u.status', 'DESC'); // Inactifs d'abord
        } elseif (in_array('ROLE_EC', $userRoles)) {
            $queryBuilder->where('u.roles LIKE :role1 OR u.roles LIKE :role2 OR u.roles LIKE :role3')
                ->setParameter('role1', '%"ROLE_CES"%')
                ->setParameter('role2', '%"ROLE_EC"%')
                ->setParameter('role3', '%"ROLE_NV"%');
            $queryBuilder->orderBy('u.status', 'DESC'); // Inactifs d'abord
        } else {
            $queryBuilder->orderBy('u.lastname', 'ASC');
        }

        // Filtrage des résultats
        if (!empty($criteria['search'])) {
            $queryBuilder->andWhere('u.lastname LIKE :search OR u.firstname LIKE :search OR u.email LIKE :search')
                ->setParameter('search', '%' . $criteria['search'] . '%');
        }

        if (!empty($criteria['profileType'])) {
            $queryBuilder->andWhere('u.roles LIKE :profileType')
                ->setParameter('profileType', '%"'.$criteria['profileType'].'"%');
        }

        if (!empty($criteria['status'])) {
            $queryBuilder->andWhere('u.status = :status')
                ->setParameter('status', $criteria['status']);
        }

        if (!empty($criteria['CES'])) {
            $queryBuilder->andWhere('ces.title = :cesTitle')
                ->setParameter('cesTitle', $criteria['CES']);
        }

        return $queryBuilder;
    }

    public function findByCes($cesId)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.ces = :cesId')
            ->setParameter('cesId', $cesId)
            ->getQuery()
            ->getResult();
    }

    public function findHomonymous(string $lastname, string $firstname, ?int $id = null): array
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->andWhere(
                'lower(u.firstname) = lower(:firstname)',
                'lower(u.lastname) = lower(:lastname)',
            )
        ;
        if ($id) {
            $queryBuilder->andWhere('u.id != :id');
        }
        $queryBuilder
            ->setParameter('lastname', $lastname)
            ->setParameter('firstname', $firstname)
        ;
        if ($id) {
            $queryBuilder->setParameter('id', $id);
        }

        return $queryBuilder->getQuery()->execute();
    }
}
