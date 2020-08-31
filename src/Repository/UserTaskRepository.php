<?php

namespace App\Repository;

use App\Entity\UserTask;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTask[]    findAll()
 * @method UserTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTask::class);
    }

    /**
     * @return UserTask[] Returns an array of UserTask objects
     */
    public function findTasksCompletedByDates($startDate)
    {
        return $this->createQueryBuilder('u')
            ->select('c.name,count(c),count(u)')
            ->join('u.category','c')
            ->andWhere('u.completionDate >= :valA')
            // ->orWhere('u.completionDate <= :valB')
            ->setParameter('valA', $startDate['startDate'])
            // ->setParameter('valB', $endDate)
            ->orderBy('u.id', 'ASC')
            ->groupBy('c.name,u')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return UserTask[] Returns an array of UserTask objects
     */
    public function findAllPendingTasks($startDate)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.startDate >= :valA')
            // ->orWhere('u.completionDate <= :valB')
            ->setParameter('valA', $startDate['startDate'])
            // ->setParameter('valB', $endDate)
            ->orderBy('u.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?UserTask
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
