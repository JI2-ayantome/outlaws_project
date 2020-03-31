<?php

namespace App\Repository;

use App\Entity\PieceIdentification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PieceIdentification|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceIdentification|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceIdentification[]    findAll()
 * @method PieceIdentification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceIdentificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceIdentification::class);
    }

    // /**
    //  * @return PieceIdentification[] Returns an array of PieceIdentification objects
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
    public function findOneBySomeField($value): ?PieceIdentification
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
