<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
/** 
 * Return number of "user" per day 
 * @return void
*/

public function countByColor() {
    $query = $this->createQueryBuilder('a')
        ->select('COUNT(a) as count', 'SUBSTRING(a.color, 1, 10) AS colorEvent')
        ->groupBy('colorEvent');
        
    return $query->getQuery()->getResult();
}



public function countMoisByDate() {
    $query = $this->createQueryBuilder('s')
        ->select('COUNT(s.id) AS count', "SUBSTRING(s.from_date, 1, 7) AS moisEvent")
        ->groupBy('moisEvent');

    return $query->getQuery()->getResult();
}

}
