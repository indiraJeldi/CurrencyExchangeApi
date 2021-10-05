<?php

namespace App\Repository;

use App\Entity\IsoCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IsoCodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsoCodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsoCodes[]    findAll()
 * @method IsoCodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsoCodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IsoCodes::class);
    }

    // /**
    //  * @return IsoCodes[] Returns an array of IsoCodes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IsoCodes
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
