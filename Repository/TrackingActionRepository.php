<?php

namespace App\Repository;

use App\Entity\TrackingAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrackingAction>
 *
 * @method TrackingAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackingAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackingAction[]    findAll()
 * @method TrackingAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackingActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrackingAction::class);
    }

    public function save(TrackingAction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrackingAction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
