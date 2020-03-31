<?php

namespace App\Repository;

use App\Entity\AuthoriteDelivrance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AuthoriteDelivrance|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthoriteDelivrance|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthoriteDelivrance[]    findAll()
 * @method AuthoriteDelivrance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthoriteDelivranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthoriteDelivrance::class);
    }

    // /**
    //  * @return AuthoriteDelivrance[] Returns an array of AuthoriteDelivrance objects
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
    public function findOneBySomeField($value): ?AuthoriteDelivrance
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
