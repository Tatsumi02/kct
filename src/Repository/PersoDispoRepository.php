<?php

namespace App\Repository;

use App\Entity\PersoDispo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersoDispo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersoDispo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersoDispo[]    findAll()
 * @method PersoDispo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersoDispoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersoDispo::class);
    }

    // /**
    //  * @return PersoDispo[] Returns an array of PersoDispo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersoDispo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
