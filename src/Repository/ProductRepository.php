<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function search($keyword, $searchType): array
    {
        if($searchType == "product"){
            $query = $this->createQueryBuilder('product')
                ->andWhere('product.nom LIKE :keyword')
                ->setParameter('keyword', "%" . $keyword . "%")
                ->orderBy('product.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }
        // if($searchType == "producteur"){
        //     $query = $this->createQueryBuilder('product')
        //         ->join('product.producteur', 'producteur')
        //         ->orWhere('producteur.nom LIKE :keyword')
        //         ->setParameter('keyword', "%" . $keyword . "%")
        //         ->orderBy('product.id', 'ASC')
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }


        return $query;
    }
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
