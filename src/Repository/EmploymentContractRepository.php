<?php

namespace App\Repository;

use App\Entity\EmploymentContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmploymentContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmploymentContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmploymentContract[]    findAll()
 * @method EmploymentContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmploymentContractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmploymentContract::class);
    }

    // /**
    //  * @return EmploymentContract[] Returns an array of EmploymentContract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmploymentContract
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
