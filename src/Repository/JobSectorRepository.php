<?php

namespace App\Repository;

use App\Entity\Job;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JobSector|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobSector|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobSector[]    findAll()
 * @method JobSector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobSectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobSector::class);
    }

    // /**
    //  * @return JobSector[] Returns an array of JobSector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobSector
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
