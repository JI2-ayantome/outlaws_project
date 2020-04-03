<?php

namespace App\Repository;

use App\Entity\Mandat;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Mandat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mandat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mandat[]    findAll()
 * @method Mandat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mandat::class);
    }

    // /**
    //  * @return Mandat[] Returns an array of Mandat objects
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
    public function findOneBySomeField($value): ?Mandat
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // /**
    //  * @return integer Return the count of all mandat objects
    //  */
    // public function getAllMandatsCount()
    // {
    //     return $this->_em->createQueryBuilder()
    //                         ->select('count(m)')
    //                         ->from($this->_entityName, 'm')
    //                         ->getQuery()
    //                         ->getSingleScalarResult()
    //                         ;

    // }

    /**
     *  @return Mandat[]|null Returns an array of Mandats objects
     */
    public function findSearch(Search $search) : ?array
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults($search->limit)
            ->setFirstResult($search->offset)
            // ->where("m.archived = false")
        ;

        // dd($search);

        if ($search->field) {   
            
            $values = explode("|", $search->q);

            switch($search->field){
                case Search::FIELD_NOM:

                    $i = 0;
                    foreach ($values as $value) {
                        # code...
                        $query
                        ->join("m.fugitif", "f")
                        ->orWhere('UPPER(f.nom) LIKE UPPER(:searchTerm'.$i.')')
                        ->setParameter('searchTerm'.$i, "%".$value."%");
                        $i++;
                    }

                    // dd($query->getDQL(), $query->getParameters());
                    ;
                break;
                case Search::FIELD_PRENOMS:

                    $i = 0;
                    foreach ($values as $value) {
                        # code...
                        $query
                        ->join("m.fugitif", "f")
                        ->orWhere('UPPER(f.prenoms) LIKE UPPER(:searchTerm'.$i.')');
                        $query->setParameter('searchTerm'.$i, "%".$value."%");
                        $i++;
                    }
                    ;
                break;
                case Search::FIELD_ADRESSE:

                    $i = 0;
                    foreach ($values as $value) {
                        # code...
                        $query
                        ->join("m.fugitif", "f")
                        ->orWhere('UPPER(f.adresse) LIKE UPPER(:searchTerm'.$i.')');
                        $query->setParameter('searchTerm'.$i, "%".$value."%");
                        $i++;
                    }
                    ;
                break;
                case Search::FIELD_EXECUTE:
                    $query
                        ->where('m.execute = :searchTerm')
                        ->setParameter('searchTerm', $search->q ? $search->q : 1)
                    ;
                break;
                case Search::FIELD_JURIDICTION:

                    $i = 0;
                    foreach ($values as $value) {
                        # code...
                        $query->orWhere('UPPER(m.juridictions) LIKE UPPER(:searchTerm'.$i.')');
                        $query->setParameter('searchTerm'.$i, "%".$value."%");
                        $i++;
                    }
                    ;
                break;
                case Search::FIELD_NATIONALITE:
                    
                    $query
                        ->join("m.fugitif", "f")
                        ->join("f.listeNationalites", "fn")
                        ->join("fn.nationalite", "n");

                    foreach ($values as $value) {
                        # code...
                        $query->orWhere('UPPER(n.libelle) LIKE UPPER(:searchTerm)');
                        $query->setParameter('searchTerm', "%".$value."%");
                    }
                    ;
                break;
                case Search::FIELD_INFRACTIONS:

                    $i = 0;
                    foreach ($values as $value) {
                        # code...
                        $query->orWhere('UPPER(m.infractions) LIKE UPPER(:searchTerm'.$i.')');
                        $query->setParameter('searchTerm'.$i, "%".$value."%");
                        $i++;
                    }
                    ; 
                break;
                default:
                    return null;
            }
        } else {

            $values = explode("|", $search->q);

            foreach ($values as $value) {
                # code...
                $query
                ->join("m.fugitif", "f")
                ->orWhere('UPPER(f.nom) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%")

                ->orWhere('UPPER(f.prenoms) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%")

                ->orWhere('UPPER(f.adresse) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%")

                ->orWhere('UPPER(m.juridictions) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%")

            
                ->join("f.listeNationalites", "fn")
                ->join("fn.nationalite", "n")
                ->orWhere('UPPER(n.libelle) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%")

                ->orWhere('UPPER(m.infractions) LIKE UPPER(:searchTerm)')
                ->setParameter('searchTerm', "%".$value."%");
            }

                // ->orWhere('UPPER(f.nom) LIKE UPPER(:searchTerm)')
                // ->setParameter('searchTerm', "%".$search->q."%")
        }
        
        //dd($query);
        
        // return ["results"   =>  $query->getQuery()->getResult(), "count" = ];
        $query->andWhere("m.archived = false");
        return $query->getQuery()->getResult();
    }
    
}
