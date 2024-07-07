<?php

namespace App\Repository;

use App\Entity\Constanciens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Constanciens>
 *
 * @method Constanciens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constanciens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constanciens[]    findAll()
 * @method Constanciens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstanciensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constanciens::class);
    }

    public function save(Constanciens $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Constanciens $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findVolunteersWithFilters(array $criteria = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('v');

        // Filtrage des résultats
        if (!empty($criteria['search'])) {
            $queryBuilder->andWhere('v.constancienId LIKE :search OR v.namePatronymic LIKE :search')
                ->setParameter('search', '%' . $criteria['search'] . '%');
        }

        if (!empty($criteria['firstName'])) {
            $queryBuilder->andWhere('v.firstname LIKE :firstName')
                ->setParameter('firstName', '%' . $criteria['firstName'] . '%');
        }

        if (!empty($criteria['birthDate'])) {
            if (is_array($criteria['birthDate'])) {
                // Filtrer par année
                $queryBuilder->andWhere('v.birthDate >= :start AND v.birthDate <= :end')
                    ->setParameter('start', $criteria['birthDate']['start'])
                    ->setParameter('end', $criteria['birthDate']['end']);
            } else {
                // Filtrer par date précise
                $startOfDay = strtotime("midnight", $criteria['birthDate']);
                $endOfDay = strtotime("tomorrow", $startOfDay) - 1;

                $queryBuilder->andWhere('v.birthDate >= :start AND v.birthDate <= :end')
                    ->setParameter('start', $startOfDay)
                    ->setParameter('end', $endOfDay);
            }
        }


        return $queryBuilder;
    }
}
