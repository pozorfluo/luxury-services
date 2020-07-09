<?php

namespace App\Repository;

use App\Entity\AdminNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminNote[]    findAll()
 * @method AdminNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminNote::class);
    }

    // /**
    //  * @return AdminNote[] Returns an array of AdminNote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminNote
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
