<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function listeLivre(): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBykeyword($value): array
    {
        return $this->createQueryBuilder('l')
            ->Where('l.titre LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderby('l.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAuteurId(?int $value)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.auteur = :val')
            ->setParameter('val', $value)
            ->orderby('l.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByGenre(?string $value): array 
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.genres', 'genre')
            ->Where ('genre.nom like :val')
            ->setParameter('val', "%$value%")
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
