<?php

namespace App\Repository;

use App\Entity\BookLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BookLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookLecturer[]    findAll()
 * @method BookLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BookLecturer::class);
    }

    // /**
    //  * @return BookLecturer[] Returns an array of BookLecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookLecturer
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
