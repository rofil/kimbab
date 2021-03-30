<?php

namespace App\Repository;

use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findAll()
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacultyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    public function findAllFaculties()
    {

        
        $qb = $this->createQueryBuilder('f');
        $qb->where($qb->expr()->eq("f.unitType", Unit::TYPE_FACULTY));

        return $qb->getQuery()->getResult();
    }


    public function getJournals($id)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->join('f.lecturers', 'l')
            ->join('l.journalLecturers', 'jl')
            ->join('jl.journal', 'j')
        ;

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Faculty[] Returns an array of Faculty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Faculty
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
