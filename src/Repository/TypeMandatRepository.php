<?php

namespace App\Repository;

use App\Entity\TypeMandat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeMandat|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMandat|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMandat[]    findAll()
 * @method TypeMandat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMandatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeMandat::class);
    }

    // /**
    //  * @return TypeMandat[] Returns an array of TypeMandat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeMandat
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
