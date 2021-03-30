<?php

namespace App\Repository;

use App\Entity\IntellectualPropertyLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IntellectualPropertyLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntellectualPropertyLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntellectualPropertyLecturer[]    findAll()
 * @method IntellectualPropertyLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntellectualPropertyLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IntellectualPropertyLecturer::class);
    }

    // /**
    //  * @return IntellectualPropertyLecturer[] Returns an array of IntellectualPropertyLecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IntellectualPropertyLecturer
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
