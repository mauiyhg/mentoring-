<?php

namespace App\Repository;

use App\Entity\Activty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activty>
 *
 * @method Activty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activty[]    findAll()
 * @method Activty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivtyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activty::class);
    }

//    /**
//     * @return Activty[] Returns an array of Activty objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Activty
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
