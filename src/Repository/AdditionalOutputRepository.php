<?php

namespace App\Repository;

use App\Entity\AdditionalOutput;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdditionalOutput|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdditionalOutput|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdditionalOutput[]    findAll()
 * @method AdditionalOutput[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdditionalOutputRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdditionalOutput::class);
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('ao');
        $qb->join('ao.additionalOutputLecturers', 'l')
            ->join('ao.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->join('r.additionalOutputLecturers', 'l')
            ->join('r.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    // /**
    //  * @return AdditionalOutput[] Returns an array of AdditionalOutput objects
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
    public function findOneBySomeField($value): ?AdditionalOutput
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
