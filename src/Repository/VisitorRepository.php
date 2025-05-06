<?php

namespace App\Repository;

use App\Entity\Visitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visitor>
 */
class VisitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visitor::class);
    }

    /**
     * @return Visitor[] Liste des utilisateurs sans le rôle producteur
     */
    public function findAllExceptProducer(): array
    {
        return $this->createQueryBuilder('u')
            ->where('NOT u.roles LIKE :role')
            ->setParameter('role', '%ROLE_PRODUCER%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Visitor[] Returns an array of Visitor objects
     */
    public function findByIdWithProducers(int $id): array
    {
        return $this->createQueryBuilder('v')
            ->addSelect('p')
            ->leftJoin('v.producer', 'p')
            ->andWhere('v.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Trouve tous les visiteurs avec leurs producteurs et produits associés.
     *
     * @param int $id L'identifiant du visiteur
     *
     * @return Visitor[] Retourne un tableau d'objets Visitor
     */
    public function findAllWithProducerAndProducts(int $id): array
    {
        return $this->createQueryBuilder('v')
            ->addSelect('producer, product')
            ->leftJoin('v.producer', 'producer')
            ->leftJoin('producer.products', 'product')
            ->andWhere('v.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Visitor
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
