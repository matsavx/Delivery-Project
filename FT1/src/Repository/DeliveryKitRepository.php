<?php

namespace App\Repository;

use App\Entity\DeliveryKit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeliveryKit|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryKit|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryKit[]    findAll()
 * @method DeliveryKit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryKitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryKit::class);
    }

    // /**
    //  * @return DeliveryKit[] Returns an array of DeliveryKit objects
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
    public function findOneBySomeField($value): ?DeliveryKit
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
