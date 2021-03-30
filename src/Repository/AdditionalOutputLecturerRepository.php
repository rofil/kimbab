<?php

namespace App\Repository;

use App\Entity\AdditionalOutputLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdditionalOutputLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdditionalOutputLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdditionalOutputLecturer[]    findAll()
 * @method AdditionalOutputLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdditionalOutputLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdditionalOutputLecturer::class);
    }

    // /**
    //  * @return AdditionalOutputLecturer[] Returns an array of AdditionalOutputLecturer objects
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
    public function findOneBySomeField($value): ?AdditionalOutputLecturer
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
