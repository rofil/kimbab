<?php

namespace App\Repository;

use App\Entity\AdditionalOutputCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdditionalOutputCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdditionalOutputCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdditionalOutputCategory[]    findAll()
 * @method AdditionalOutputCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdditionalOutputCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdditionalOutputCategory::class);
    }

    // /**
    //  * @return AdditionalOutputCategory[] Returns an array of AdditionalOutputCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdditionalOutputCategory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
