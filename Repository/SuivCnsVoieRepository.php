<?php

namespace App\Repository;

use App\Entity\SuivCnsVoie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuivCnsVoie>
 *
 * @method SuivCnsVoie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuivCnsVoie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuivCnsVoie[]    findAll()
 * @method SuivCnsVoie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuivCnsVoieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuivCnsVoie::class);
    }

    public function save(SuivCnsVoie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuivCnsVoie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Add custom repository methods if needed
}
