<?php

namespace App\Repository;

use App\Entity\ConferenceOrganizer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConferenceOrganizer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConferenceOrganizer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConferenceOrganizer[]    findAll()
 * @method ConferenceOrganizer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceOrganizerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConferenceOrganizer::class);
    }

    // /**
    //  * @return ConferenceOrganizer[] Returns an array of ConferenceOrganizer objects
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
    public function findOneBySomeField($value): ?ConferenceOrganizer
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
