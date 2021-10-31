<?php

namespace App\Repository;

use App\Entity\DeliveryDrink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeliveryDrink|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryDrink|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryDrink[]    findAll()
 * @method DeliveryDrink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryDrinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryDrink::class);
    }

    // /**
    //  * @return DeliveryDrink[] Returns an array of DeliveryDrink objects
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
    public function findOneBySomeField($value): ?DeliveryDrink
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
