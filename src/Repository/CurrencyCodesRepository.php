<?php

namespace App\Repository;

use App\Entity\CurrencyCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CurrencyCodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyCodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyCodes[]    findAll()
 * @method CurrencyCodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyCodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyCodes::class);
    }

    // /**
    //  * @return CurrencyCodes[] Returns an array of CurrencyCodes objects
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
    public function findOneBySomeField($value): ?CurrencyCodes
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return CurrencyCodes[]
     */
    public function findAllCodes(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT *
            FROM App\Entity\CurrencyCodes cc
            ORDER BY cc.code ASC'
        );

        // returns an array of Product objects
        return $query->getResult();
    }
}
