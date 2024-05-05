<?php



namespace App\Repository;

use App\Entity\Commentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommentairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaires::class);
    }
    public function findByAverageRoundedNoteByUser()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.user_id', 'AVG(c.Note) AS avg_note')
           ->groupBy('c.user_id');
        
        $results = $qb->getQuery()->getResult();
        
        // Perform rounding in PHP
        foreach ($results as &$result) {
            $result['avg_note'] = round($result['avg_note']);
        }
        
        return $results;
    }
    
    
    
}
