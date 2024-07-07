<?php

namespace App\Repository;

use App\Entity\RefCes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefCes|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefCes|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefCes[]    findAll()
 * @method RefCes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefCesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefCes::class);
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


    public function findAllCes()
    {
        return $this->createQueryBuilder('r')
            ->getQuery()
            ->getResult();
    }
}
