<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Grocery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

/**
 * @extends ServiceEntityRepository<Grocery>
 */
class GroceryRepository extends ServiceEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grocery::class);
    }

    /**
     * @param string[] $filters
     * @return Paginator<mixed>
     */
    public function findPaginated(int $page, int $limit, array $filters = []): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        foreach ($filters as $field => $value) {
            $queryBuilder->andWhere("g.$field = :$field")
                ->setParameter($field, $value);
        }

        return new Paginator($queryBuilder->getQuery());
    }

    /**
     * @param Grocery[] $groceryEntities
     * @throws \Exception
     */
    public function bulkInsert(array $groceryEntities): void
    {
        $this->_em->beginTransaction();

        try {
            foreach ($groceryEntities as $groceryEntity) {
                $this->_em->persist($groceryEntity);
            }

             $this->_em->flush();
             $this->_em->commit();
        } catch (\Exception $e) {
             $this->_em->rollback();
            throw $e;
        }
    }

    public function save(Grocery $grocery): void
    {
        $this->_em->persist($grocery);
        $this->_em->flush();
    }
}
