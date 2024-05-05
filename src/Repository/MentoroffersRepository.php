<?php

namespace App\Repository;
use App\Entity\User;
use App\Entity\Mentoroffers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mentoroffers>
 *
 * @method Mentoroffers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mentoroffers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mentoroffers[]    findAll()
 * @method Mentoroffers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MentoroffersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mentoroffers::class);
    }

    public function findOffersByMentor(User $mentor)
    {
        return $this->createQueryBuilder('mo')
            ->andWhere('mo.mentor = :mentor')
            ->setParameter('mentor', $mentor)
            ->getQuery()
            ->getResult();
    }
    
}
