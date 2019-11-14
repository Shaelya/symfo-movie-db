<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * méthode qui permet d'ordonner les films par ordre alphabétique, avec le query builder (qb)
     * @return Movie[] Returns an array of Movie objects
     */
    public function findAllOrderedByTitle()
    {
        $query = $this->createQueryBuilder('m')
                      ->orderBy('m.title', 'ASC');

        return $query->getQuery()->getResult();
        ;
    }

    /**
     *  Alternative : utiliser DQL (Doctrine Query Language )
     * @return Movie[] Returns an array of Movie objects
     */
    public function findAllOrderedByTitleDQL()
    {
        return $this->getEntityManager()
                    ->createQuery('
                        SELECT m
                        FROM App\Entity\Movie m
                        ORDER BY m.title ASC
                    ')
                    ->getResult();
        ;
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
