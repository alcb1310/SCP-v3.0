<?php

namespace App\Repository;

use App\Entity\Partida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Partida|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partida|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partida[]    findAll()
 * @method Partida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partida::class);
    }

    public function getAllAcumula()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.acumula = true')
            ->addOrderBy('p.codigo')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Partida[] Returns an array of Partida objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partida
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
