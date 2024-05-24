<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
    * @return Produit[] Returns an array of Produit objects
    */
    public function search($keyword, $searchType): array
    {
        //Selon la variableSearchType venant du formulaire, on fait une requête différente
        if($searchType == "produit"){
            $query = $this->createQueryBuilder('produit')
                ->andWhere('produit.nom LIKE :keyword')
                ->setParameter('keyword', "%" . $keyword . "%")
                ->orderBy('produit.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }
        if($searchType == "producteur"){
            $query = $this->createQueryBuilder('produit')
                ->join('produit.producteur', 'producteur')
                ->orWhere('producteur.nom LIKE :keyword')
                ->setParameter('keyword', "%" . $keyword . "%")
                ->orderBy('produit.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }


        return $query;
    }
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
