<?php

namespace App\Repository;

use App\Entity\Year;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Year|null find($id, $lockMode = null, $lockVersion = null)
 * @method Year|null findOneBy(array $criteria, array $orderBy = null)
 * @method Year[]    findAll()
 * @method Year[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YearRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Year::class);
    }

    public function journalNumber(array $options= [])
    {
        $qb = $this->createQueryBuilder('y');
        $qb->select("y.year")
            ->join('y.journals', 'c')
            ->addSelect("count('select count(c.id) from App\Entity\Journal') as jum")
            ->groupBy('y.id')
        ;

        if (key_exists('faculty', $options)) {
            $qb->join('c.journalLecturers', 'jl')->join('jl.lecturer', 'l');
            $qb->andWhere($qb->expr()->eq('l.unit', $options['faculty']));

        }

        if (key_exists('lecturer', $options)) {
            $qb->join('c.journalLecturers', 'jl');
            $qb->andWhere($qb->expr()->eq('jl.lecturer', $options['lecturer']));
        }

        return $qb->getQuery()->getResult();
    }

    public function conferenceNumber(array $options= [])
    {
        $qb = $this->createQueryBuilder('y');
        $qb->select("y.year")
            ->join('y.conferences', 'c')
            ->addSelect("count('select count(c.id) from App\Entity\Conference') as jum")
            ->groupBy('y.id')
        ;

        if (key_exists('faculty', $options)) {
            $qb->join('c.journalLecturers', 'jl')->join('jl.lecturer', 'l');
            $qb->andWhere($qb->expr()->eq('l.unit', $options['faculty']));

        }

        if (key_exists('lecturer', $options)) {
            $qb->join('c.conferenceLecturers', 'cl');
            $qb->andWhere($qb->expr()->eq('cl.lecturer', $options['lecturer']));
        }

        return $qb->getQuery()->getResult();
    }

    public function bookNumber(array $options= [])
    {
        $qb = $this->createQueryBuilder('y');
        $qb->select("y.year")
            ->join('y.books', 'b')
            ->addSelect("count('select count(b.id) from App\Entity\Book') as jum")
            ->groupBy('y.id')
        ;

        if (key_exists('faculty', $options)) {
            $qb->join('c.journalLecturers', 'jl')->join('jl.lecturer', 'l');
            $qb->andWhere($qb->expr()->eq('l.unit', $options['faculty']));

        }

        if (key_exists('lecturer', $options)) {
            $qb->join('b.bookLecturers', 'bl');
            $qb->andWhere($qb->expr()->eq('bl.lecturer', $options['lecturer']));
        }

        return $qb->getQuery()->getResult();
    }

    public function pub(array $years=[], array $options = [])
    {
        $data = array_combine($years, [0]);

        $journals= $this->journalNumber($options);
        foreach ($journals as $journal) {
            if (key_exists($journal['year'], $data))
                $data[$journal['year']] += $journal['jum'];
        }

        $conferences= $this->conferenceNumber($options);
        foreach ($conferences as $conference) {
            if (key_exists($conference['year'], $data))
                $data[$conference['year']] += $conference['jum'];
        }

        $books= $this->bookNumber($options);
        foreach ($books as $book) {
            if (key_exists($book['year'], $data))
                $data[$book['year']] += $book['jum'];
        }

        return $data;
    }
    // /**
    //  * @return Year[] Returns an array of Year objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Year
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
