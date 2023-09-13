<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }

    public function listeEmprunteur(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByUserId($value): ?Emprunteur
    {
        return $this->createQueryBuilder('e')
            ->where('e.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByKeyword($value): array
        {
            return $this->createQueryBuilder('e')
                ->where('e.nom like :val')
                ->orWhere('e.prenom like :val')
                ->setParameter('val', "%$value%")
                ->orderBy('e.nom', 'ASC')
                ->addOrderBy('e.prenom', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function findByTel($value): array
        {
            return $this->createQueryBuilder('e')
                ->where('e.tel like :val')
                ->setParameter('val', "%$value%")
                ->orderBy('e.nom', 'ASC')
                ->addOrderBy('e.prenom', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function findByCreatedAt($value): array
        {
            return $this->createQueryBuilder('e')
                ->where('e.createdAt < :val')
                ->setParameter('val', $value)
                ->orderBy('e.nom', 'ASC')
                ->addOrderBy('e.prenom', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }



//    /**
//     * @return Emprunteur[] Returns an array of Emprunteur objects
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

//    public function findOneBySomeField($value): ?Emprunteur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
