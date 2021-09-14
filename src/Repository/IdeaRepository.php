<?php

namespace App\Repository;

use App\Entity\Idea;
use App\Entity\Filter;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Idea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idea[]    findAll()
 * @method Idea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Idea::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
    public function findSearch(Filter $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('idea');

        if (($search->popular)) {
            $query = $query
                ->orderBy('idea.inFavor', 'DESC');
        }

        if (($search->chrono)) {
            $query = $query
                ->orderBy('idea.create_at', 'ASC');
        }

        if (($search->reverse)) {
            $query = $query
                ->orderBy('idea.create_at', 'DESC');
        }

        $query = $query->getQuery()->getResult();
        return $this->paginator->paginate(
            $query,
            $search->page,
            15
        );
    }

    // private function getSearchQuery(Filter $search): QueryBuilder
    // {
    // }

    // /**
    //  * @return Idea[] Returns an array of Idea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Idea
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
