<?php

namespace App\Repository;

use App\Entity\JournalLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JournalLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalLecturer[]    findAll()
 * @method JournalLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JournalLecturer::class);
    }

    public function findByLecturers(array $lecturer)
    {

    }



    // /**
    //  * @return JournalLecturer[] Returns an array of JournalLecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JournalLecturer
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
