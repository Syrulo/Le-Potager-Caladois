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

    public function findAllExceptProducer()
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
    public function findByIdWithProducers($id): array
    {
        return $this->createQueryBuilder('v')
            ->addSelect('p')
            ->leftJoin('v.producers', 'p')
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
