<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findLatest()
    {
        $qb = $this->createQueryBuilder("b");
        $qb->join("b.year", "y");
        $qb->orderBy("b.createdAt", "DESC")->orderBy("y.year", "DESC");
        return $qb->getQuery()->getResult();
    }

    public function findByPeople($id)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->join('b.bookLecturers', 'l')
            ->join('b.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $id));

        return $qb->getQuery()->getResult();
    }

    public function findByLecturers(array $ids)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->join('b.bookLecturers', 'l')
            ->join('b.year', 'y')
            ->orderBy("y.year", 'DESC');
        $qb->andWhere($qb->expr()->in('l.lecturer', $ids));

        return new ArrayCollection($qb->getQuery()->getResult());
    }


    public function stat(array $options = [])
    {
        $qb = $this->createQueryBuilder('b');

        $qb->select('b.year')
            ->join('b.year','y')
            ->join('b.bookLecturers', 'bl');

        $qb->select("y.year, COUNT(b.id) as jum")
            ->groupBy('b.year')
        ;

        if (key_exists('ids', $options)) {
            $qb->andWhere($qb->expr()->in('bl.lecturer', $options['ids']));
        }

        $result = $qb->getQuery()->getResult();

        return $years = remake_array($result, 'year', 'jum');
    }

    public function statByLecturersPerYears(array $ids, array $years)
    {
        return add_merge($years, $this->stat(['ids' => $ids]));
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
