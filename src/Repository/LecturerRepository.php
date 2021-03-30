<?php

namespace App\Repository;

use App\Entity\Lecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lecturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecturer[]    findAll()
 * @method Lecturer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LecturerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lecturer::class);
    }

    public function findWithFaculty(array $options = [])
    {
        $qb = $this->createQueryBuilder('l');

        $qb->join('l.unit', 'u')
            ->andWhere($qb->expr()->eq('l.status', 1))
        ;

        return $qb->getQuery()->getResult();
    }

    public function findOneWithAttribute($id, array $options = [])
    {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->join('l.unit', 'u')
//            ->join('l.bookLecturers', 'lb')->join('lb.book', 'book')
//            ->join('l.journalLecturers', 'jl')->join('jl.journal','journal')
        ;

        $qb->andWhere($qb->expr()->eq('l.id', $id));

        return $qb->getQuery()->getSingleResult();
    }

    public function getCount(array $option = [])
    {
        $qb = $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->andWhere("l.affiliation =:affiliation")
            ->setParameter("affiliation", "Universitas Mulawarman")
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getJafungStat(array $options = [])
    {
        $qb = $this->createQueryBuilder("l");
        $qb->select('l.functional, count(l.id) as jum')->groupBy("l.functional");
        $qb->andWhere($qb->expr()->eq("l.status", 1));

        if (key_exists('faculty', $options))
            $qb->andWhere($qb->expr()->eq('l.unit', $options['faculty']));

        return $qb->getQuery()->getResult();
    }

    public function getIdsByFaculty($faculty_id)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('l.id')
            ->andWhere($qb->expr()->eq('l.unit', $faculty_id))
            ;
        return $qb->getQuery()->getResult();
    }

    public function getIdLecturers($faculty): array
    {
        $data = [];
        foreach ($this->getIdsByFaculty($faculty) as $item) {
            $data[] = $item['id'];
        }

        return $data;
    }

    // /**
    //  * @return Lecturer[] Returns an array of Lecturer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lecturer
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
