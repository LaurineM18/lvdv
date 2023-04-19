<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Vitrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vitrine>
 *
 * @method Vitrine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vitrine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vitrine[]    findAll()
 * @method Vitrine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VitrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vitrine::class);
    }

    public function save(Vitrine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vitrine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return Vitrine[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');

        if(!empty($search->q)){
            $query = $query
                ->andWhere('p.Name LIKE :q')
                ->setParameter('q', "%{$search->q}%")
                ->orderBy('p.id', 'DESC');
        }

        if(!empty($search->new)){
            $query = $query
                ->andWhere('p.New = 1');
        }

        if(!empty($search->available)){
            $query = $query
                ->andWhere('p.Available = 1');
        }

        if(!empty($search->theme)){
            $query = $query
                ->andWhere('p.theme IN (:theme)')
                ->setParameter('theme', $search->theme);
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Vitrine[] Returns an array of Vitrine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vitrine
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
