<?php

namespace App\Repository;

use App\Entity\Producteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Producteur>
 */
class ProducteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producteur::class);
    }

    //     /**
    // * @return Producteur[] Retourne un tableau de producteurs
    // */
    // public function search($keyword, $searchType): array
    // {
    //         if($searchType == "producteur"){
    //             $query = $this->createQueryBuilder('producteur')
    //                 ->andWhere('producteur.nom LIKE :keyword')
    //                 ->setParameter('keyword', "%" . $keyword . "%")
    //                 ->orderBy('producteur.id', 'ASC')
    //                 ->getQuery()
    //                 ->getResult()
    //             ;
    //         }
    //         return $query;
    // }
}
