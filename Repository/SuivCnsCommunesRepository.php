<?php

namespace App\Repository;

use App\Entity\SuivCnsCommunes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuivCnsCommunes>
 *
 * @method SuivCnsCommunes|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuivCnsCommunes|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuivCnsCommunes[]    findAll()
 * @method SuivCnsCommunes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuivCnsCommunesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuivCnsCommunes::class);
    }

    public function save(SuivCnsCommunes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuivCnsCommunes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
