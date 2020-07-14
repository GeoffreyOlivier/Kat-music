<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
     * @return Commentaire[] Returns an array of Commentaire objects
     */

    public function Commentaire()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult()
        ;
    }
    public function CommentairePair()
    {
        return $this->createQueryBuilder('c')
            ->where("mod(c.id,2) = 0")
            ->getQuery()
            ->getResult()
            ;
    }
    public function CommentaireImpair()
    {
        return $this->createQueryBuilder('c')
            ->where("mod(c.id,2) = 1")
            ->getQuery()
            ->getResult()
            ;
    }


    public function CommentaireAccueil()
    {
        return $this->createQueryBuilder('c')
            ->setMaxResults(3)
            ->orderBy('c.id','DESC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Commentaire
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
