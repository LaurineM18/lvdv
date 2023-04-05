<?php

namespace App\Repository;

use App\Entity\SubjectVitrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubjectVitrine>
 *
 * @method SubjectVitrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectVitrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectVitrine[]    findAll()
 * @method SubjectVitrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectVitrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectVitrine::class);
    }

    public function save(SubjectVitrine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SubjectVitrine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SubjectVitrine[] Returns an array of SubjectVitrine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SubjectVitrine
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
