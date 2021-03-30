<?php

namespace App\Repository;

use App\Entity\ConferenceLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConferenceLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConferenceLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConferenceLecturer[]    findAll()
 * @method ConferenceLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConferenceLecturer::class);
    }

    // /**
    //  * @return ConferenceLecturer[] Returns an array of ConferenceLecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConferenceLecturer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
