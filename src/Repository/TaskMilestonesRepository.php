<?php

namespace App\Repository;

use App\Entity\TaskMilestones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskMilestones|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskMilestones|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskMilestones[]    findAll()
 * @method TaskMilestones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskMilestonesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskMilestones::class);
    }

    // /**
    //  * @return TaskMilestones[] Returns an array of TaskMilestones objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskMilestones
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
