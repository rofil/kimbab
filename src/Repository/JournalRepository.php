<?php

namespace App\Repository;

use App\Entity\Journal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Journal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Journal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Journal[]    findAll()
 * @method Journal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Journal::class);
    }

    public function findLatest()
    {
        $qb = $this->createQueryBuilder("j");
        $qb->join("j.year", "y");
        $qb->orderBy("j.createdAt", "DESC")->orderBy("y.year", "DESC");
        return $qb->getQuery()->getResult();
    }

    public function getCount()
    {
        $qb = $this->createQueryBuilder("j")
            ->select('count(j.id)');


        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('j');
        $qb->join('j.journalLecturers', 'l')
            ->join('j.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('j');
        $qb->join('j.journalLecturers', 'l')
            ->join('j.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));
        if (count($qb->getQuery()->getResult()) == 0)
            return new ArrayCollection([]);
        return new ArrayCollection($qb->getQuery()->getResult());
    }

    public function journalStat(array $options = [])
    {
        $qb = $this->createQueryBuilder('j');

        $qb->select('j.year')
            ->join('j.year','y')
            ->join('j.journalLecturers', 'jl');

        $qb->select("y.year, COUNT(j.id) as jum")
            ->groupBy('j.year')
        ;

        if (key_exists('ids', $options)) {
            $qb->andWhere($qb->expr()->in('jl.lecturer', $options['ids']));
        }

        $result = $qb->getQuery()->getResult();

        return $years = remake_array($result, 'year', 'jum');
    }

    public function journalStatByLecturersYears(array $ids, array $years)
    {
        return add_merge($years, $this->journalStat(['ids' => $ids]));
    }


    // /**
    //  * @return Journal[] Returns an array of Journal objects
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
    public function findOneBySomeField($value): ?Journal
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
