<?php

namespace App\Repository;

use App\Entity\IntellectualProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IntellectualProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntellectualProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntellectualProperty[]    findAll()
 * @method IntellectualProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntellectualPropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IntellectualProperty::class);
    }

    public function getCount(array $option = [])
    {
        $qb = $this->createQueryBuilder('ip')
            ->select('COUNT(ip.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('ip');
        $qb->join('ip.intellectualPropertyLecturers', 'l')
            ->join('ip.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('ip');
        $qb->join('ip.intellectualPropertyLecturers', 'l')
            ->join('ip.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    // /**
    //  * @return IntellectualProperty[] Returns an array of IntellectualProperty objects
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
    public function findOneBySomeField($value): ?IntellectualProperty
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
