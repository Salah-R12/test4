<?php

namespace App\Repository;

use App\Entity\RefCpam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefCpam|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefCpam|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefCpam[]    findAll()
 * @method RefCpam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefCpamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefCpam::class);
    }

    public function findByCes($cesId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.ref_ces = :cesId')
            ->setParameter('cesId', $cesId)
            ->getQuery()
            ->getResult();
    }
}