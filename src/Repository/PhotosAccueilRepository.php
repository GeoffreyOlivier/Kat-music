<?php

namespace App\Repository;

use App\Entity\PhotosAccueil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotosAccueil|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotosAccueil|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotosAccueil[]    findAll()
 * @method PhotosAccueil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotosAccueilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotosAccueil::class);
    }

    /**
     * @return PhotosAccueil[] Returns an array of PhotosAccueil objects
     */

    public function getPhotos()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?PhotosAccueil
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
