<?php

namespace App\Repository;

use App\Entity\CommunityServiceLecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommunityServiceLecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommunityServiceLecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommunityServiceLecturer[]    findAll()
 * @method CommunityServiceLecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunityServiceLecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommunityServiceLecturer::class);
    }

    // /**
    //  * @return CommunityServiceLecturer[] Returns an array of CommunityServiceLecturer objects
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
    public function findOneBySomeField($value): ?CommunityServiceLecturer
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
