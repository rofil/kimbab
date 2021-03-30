<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    public function findLatest()
    {
        $qb = $this->createQueryBuilder("c");
        $qb->join("c.year", "y");
        $qb->orderBy("y.year", "DESC")->orderBy("c.createdAt", "DESC");
        return $qb->getQuery()->getResult();
    }

    public function getCount(array $option = [])
    {
        $qb = $this->createQueryBuilder("c")
            ->select('count(c.id)');


        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->join('c.conferenceLecturers', 'l')
            ->join('c.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->join('c.conferenceLecturers', 'l')
            ->join('c.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    public function stat(array $options = [])
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('c.year')
            ->join('c.year','y')
            ->join('c.conferenceLecturers', 'cl');

        $qb->select("y.year, COUNT(c.id) as jum")
            ->groupBy('c.year')
        ;

        if (key_exists('ids', $options)) {
            $qb->andWhere($qb->expr()->in('cl.lecturer', $options['ids']));
        }

        $result = $qb->getQuery()->getResult();

        return $years = remake_array($result, 'year', 'jum');
    }

    public function statByLecturersPerYears(array $ids, array $years)
    {
        return add_merge($years, $this->stat(['ids' => $ids]));
    }

    // /**
    //  * @return Conference[] Returns an array of Conference objects
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
    public function findOneBySomeField($value): ?Conference
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
