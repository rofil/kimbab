<?php

namespace App\Repository;

use App\Entity\CommunityService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommunityService|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommunityService|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommunityService[]    findAll()
 * @method CommunityService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunityServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommunityService::class);
    }

    public function getCount(array $option = [])
    {
        $qb = $this->createQueryBuilder('cs')
            ->select('COUNT(cs.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('com');
        $qb->join('com.communityServiceLecturers', 'l');
        $qb->join('com.communityServicePartners', 'p')
            ->join('com.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('com');
        $qb->join('com.communityServiceLecturers', 'l')
            ->join('com.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }
    // /**
    //  * @return CommunityService[] Returns an array of CommunityService objects
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
    public function findOneBySomeField($value): ?CommunityService
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
