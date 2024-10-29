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
     * Recherche des produits en fonction d'un mot-clé et d'un type de recherche.
     *
     * @param string $keyword Le mot-clé de recherche
     * @param string $searchType Le type de recherche (par exemple, "produit")
     * @return array Un tableau de résultats de recherche
     */
    public function search($keyword, $searchType): array
    {
        $query = null;

        if ($searchType == "produit") {
            $query = $this->createQueryBuilder('produit')
                ->andWhere('produit.nom LIKE :keyword')
                ->setParameter('keyword', "%" . $keyword . "%")
                ->orderBy('produit.id', 'ASC')
                ->getQuery()
                ->getResult();
        }
        if ($query === null) {
            // Si aucun résultat n'est trouvé, retourner un tableau vide
            return [];
        }

        return $query;
    }

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
