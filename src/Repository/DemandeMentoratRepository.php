<?php

namespace App\Repository;

use App\Entity\DemandeMentorat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeMentorat>
 *
 * @method DemandeMentorat|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeMentorat|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeMentorat[]    findAll()
 * @method DemandeMentorat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeMentoratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeMentorat::class);
    }

    //    /**
    //     * @return DemandeMentorat[] Returns an array of DemandeMentorat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DemandeMentorat
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
