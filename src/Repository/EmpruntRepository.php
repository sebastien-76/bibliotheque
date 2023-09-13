<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

        public function findByDateEmprunt(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date_emprunt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdEmprunteur($value): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.emprunteur = :val')
            ->setParameter('val', $value)
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdLivre($value): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.livre = :val')
            ->setParameter('val', $value)
            ->orderBy('e.date_emprunt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByDateRetour(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date_retour', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNonRetour(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.date_retour IS null')
            ->orderBy('e.date_emprunt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Emprunt[] Returns an array of Emprunt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emprunt
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}