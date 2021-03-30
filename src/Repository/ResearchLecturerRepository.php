<?php

namespace App\Repository;

use App\Entity\ResearchLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResearchLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResearchLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResearchLecturer[]    findAll()
 * @method ResearchLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResearchLecturer::class);
    }

    // /**
    //  * @return ResearchLecturer[] Returns an array of ResearchLecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResearchLecturer
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
