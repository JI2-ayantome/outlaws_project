<?php

namespace App\Repository;

use App\Entity\NaturePiece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NaturePiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method NaturePiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method NaturePiece[]    findAll()
 * @method NaturePiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NaturePieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NaturePiece::class);
    }

    // /**
    //  * @return NaturePiece[] Returns an array of NaturePiece objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NaturePiece
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
