<?php

namespace App\Repository;

use App\Entity\RefCesSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefCesSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefCesSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefCesSite[]    findAll()
 * @method RefCesSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefCesSite::class);
    }

    // Exemple de méthode personnalisée
    public function findByTitle($title)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getResult();
    }
}
