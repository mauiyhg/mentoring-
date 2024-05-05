<?php

namespace App\Repository;

use App\Entity\EducationalEtablissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationalEtablissement>
 *
 * @method EducationalEtablissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationalEtablissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationalEtablissement[]    findAll()
 * @method EducationalEtablissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationalEtablissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationalEtablissement::class);
    }

//    /**
//     * @return EducationalEtablissement[] Returns an array of EducationalEtablissement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EducationalEtablissement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
