<?php

namespace App\Repository;

use App\Entity\TrackingConnection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrackingConnection>
 *
 * @method TrackingConnection|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackingConnection|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackingConnection[]    findAll()
 * @method TrackingConnection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackingConnectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackingConnection::class);
    }

    public function save(TrackingConnection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrackingConnection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
