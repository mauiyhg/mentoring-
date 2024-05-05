<?php

namespace App\Repository;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
/** 
 * Return number of "user" per day 
 * @return void
*/

public function countByDate() {
    $query = $this->createQueryBuilder('a')
        ->select('COUNT(a) as count', 'SUBSTRING(a.roles, 1, 10) AS dateUser')
        ->groupBy('dateUser');
        
    return $query->getQuery()->getResult();
}

public function countByDateLine() {
    $query = $this->createQueryBuilder('u')
        ->select('COUNT(u) as count', 'SUBSTRING(u.created_at, 1, 7) AS userLine')
        ->groupBy('userLine');
        
    return $query->getQuery()->getResult();
}

//SELECT COUNT(*), SUBSTRING(created_at, 1, 7) AS userLine FROM user GROUP BY userLine;



public function countByDateMonth() {
    $query = $this->createQueryBuilder('u')
        ->select('COUNT(u.id) AS count', "SUBSTRING(u.created_at, 1, 7) AS mois")
        ->groupBy('mois');

    return $query->getQuery()->getResult();
}



 // SELECT COUNT(*), SUBSTRING(created_at, 1, 7) AS userLine FROM user GROUP BY userLine; -->






//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
