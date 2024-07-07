<?php

namespace App\Repository;

use App\Entity\SuivCnsAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuivCnsAdresse>
 *
 * @method SuivCnsAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuivCnsAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuivCnsAdresse[]    findAll()
 * @method SuivCnsAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuivCnsAdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuivCnsAdresse::class);
    }

    public function save(SuivCnsAdresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuivCnsAdresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
