<?php

namespace App\Repository;

use App\Entity\SuivRgpd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuivRgpd>
 *
 * @method SuivRgpd|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuivRgpd|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuivRgpd[]    findAll()
 * @method SuivRgpd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuivRgpdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuivRgpd::class);
    }

    public function save(SuivRgpd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuivRgpd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Add custom repository methods if needed
}
