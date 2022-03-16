<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Category;
use App\Domain\Exception\Category\CategoryNotFoundException;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Repository\CategoryRepository;
use App\Infrastructure\Exception\InfraException;
use App\Infrastructure\Persistence\Exception\DatabaseAccessException;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

class CategoryDoctrineRepository extends AbstractEntityRepository implements CategoryRepository
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @throws InfraExceptionInterface
     */
    public function save(Category $category): void
    {
        try {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
        } catch (DBALException|ORMException $e) {
            throw new DatabaseAccessException($e);
        }
    }

    public function findById(int $categoryId): Category
    {
        $queryBuilder = $this->initFindbyIdQueryBuilder($categoryId);
        try {
            /** @var Category $category */
            $category = $queryBuilder
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw CategoryNotFoundException::forCategoryId($categoryId, $exception);
        } catch (DBALException|NonUniqueResultException $exception) {
            throw new InfraException($exception->getMessage(), $exception);
        }

        return $category;
    }

    public function findByListId(array $categoryListId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        try {
            /** @var array $categories */
            $categories = $queryBuilder
                ->select('category')
                ->from(Category::class, 'category')
                ->where('category.id IN (:category_id)')
                ->setParameter('category_id', $categoryListId, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
                ->getQuery()
                ->getResult();
        } catch (DBALException|NonUniqueResultException $exception) {
            throw new InfraException($exception->getMessage(), $exception);
        }

        return $categories;
    }

    private function initFindbyIdQueryBuilder(int $categoryId): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('category')
            ->from(Category::class, 'category')
            ->where('category.id = :category_id')
            ->setParameter('category_id', $categoryId);

        return $queryBuilder;
    }
}