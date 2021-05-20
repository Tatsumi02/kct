<?php

namespace App\Repository;

use App\Entity\DemandeCommu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeCommu|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeCommu|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeCommu[]    findAll()
 * @method DemandeCommu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCommuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeCommu::class);
    }

    // /**
    //  * @return DemandeCommu[] Returns an array of DemandeCommu objects
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
    public function findOneBySomeField($value): ?DemandeCommu
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
