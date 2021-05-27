<?php

namespace App\Repository;

use App\Entity\MembreCommu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MembreCommu|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembreCommu|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembreCommu[]    findAll()
 * @method MembreCommu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembreCommuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembreCommu::class);
    }

    // /**
    //  * @return MembreCommu[] Returns an array of MembreCommu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MembreCommu
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
