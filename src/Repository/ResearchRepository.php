<?php

namespace App\Repository;

use App\Entity\Research;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Research|null find($id, $lockMode = null, $lockVersion = null)
 * @method Research|null findOneBy(array $criteria, array $orderBy = null)
 * @method Research[]    findAll()
 * @method Research[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Research::class);
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->join('r.researchLecturers', 'l')
            ->join('r.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->join('r.researchLecturers', 'l')
            ->join('r.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    // /**
    //  * @return Research[] Returns an array of Research objects
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
    public function findOneBySomeField($value): ?Research
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
