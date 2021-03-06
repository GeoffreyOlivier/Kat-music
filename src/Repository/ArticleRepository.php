<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\CommentaireArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */

    public function sidebarArticles()
    {
        return $this->createQueryBuilder('a')
            ->setMaxResults(3)
            ->orderBy('a.id','DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */

    public function LastArticle()
    {
        return $this->createQueryBuilder('a')
            ->setMaxResults(1)
            ->orderBy('a.id','DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */

     public function Articles()
     {
         return $this->createQueryBuilder('a')
             ->orderBy('a.id','DESC')
             ->getQuery()
             ->getResult();
     }

//    /**
//     * @return \Doctrine\ORM\QueryBuilder
//     */
//
//    public function CommentaireValide2()
//    {
//        return $this->createQueryBuilder('a')
//            ->innerJoin(
//                CommentaireArticle::class,    // Entity
//                'c',               // Alias
//                Join::WITH,        // Join type
//                'c.article_id = a.id')
//            ->where('p.valide =:1')
//            ->getQuery()
//            ->getResult();
//    }

    /**
     * @return Article[] Returns an array of Article objects
     */

    public function ArticleId()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id','DESC')
            ->getQuery()
            ->getResult();
    }



    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
