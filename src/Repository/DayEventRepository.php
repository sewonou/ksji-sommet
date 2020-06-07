<?php

namespace App\Repository;

use App\Entity\DayEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DayEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method DayEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method DayEvent[]    findAll()
 * @method DayEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DayEvent::class);
    }

    // /**
    //  * @return DayEvent[] Returns an array of DayEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DayEvent
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
