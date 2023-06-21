<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Vitrine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Vitrine::class);
        $this->paginator = $paginator;
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
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search, $nb): PaginationInterface
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

        if(!empty($search->format)){
            $query = $query
                ->andWhere('p.format IN (:format)')
                ->setParameter('format', $search->format);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            $nb
        );
    }

    public function orderByDesc() : array
    {
        $qb = $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC');

        return $qb->getQuery()->getResult(); 
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
