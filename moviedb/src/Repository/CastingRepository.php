<?php

namespace App\Repository;

use App\Entity\Casting;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Casting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casting[]    findAll()
 * @method Casting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CastingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casting::class);
    }

    /**
     * Récupérer les castings d'un movie donné + le sinfos de Person
     * Méthode DQL
     * 
     * @param Movie $movie
     * @return Casting[]
     */
    public function findByMovieDQL($movie)
    {
        $query = $this->getEntityManager()
                    ->createQuery('
                        SELECT c, p
                        FROM App\Entity\Casting c
                        JOIN c.person p
                        WHERE c.movie = :movie
                    ')
                    ->setParameter('movie', $movie);
                    return $query->getResult();
        ;
    }


    /**
     * Récupérer les castings d'un movie donné + le sinfos de Person
     * Méthode Query Builder
     * 
     * @param Movie $movie
     * @return Casting[]
     */
    public function findByMovie($movie)
    {
        $qb = $this->createQueryBuilder('c')
                    ->join('c.person', 'p')
                    ->addSelect('p')
                    ->where('c.movie = :myMovie')
                    ->setParameter('myMovie', $movie)
                    ;
        return $qb->getQuery()->getResult();
        ;
    }


    // /**
    //  * @return Casting[] Returns an array of Casting objects
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
    public function findOneBySomeField($value): ?Casting
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
