<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Product;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Repository\ProductRepository;
use App\Infrastructure\Exception\InfraException;
use App\Infrastructure\Persistence\Exception\DatabaseAccessException;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;

class ProductDoctrineRepository extends AbstractEntityRepository implements ProductRepository
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @throws InfraExceptionInterface
     */
    public function save(Product $product)
    {
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (DBALException|ORMException $e) {
            throw new DatabaseAccessException($e);
        }
    }

    public function findByCategory(int $categoryId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder('p');
        try {
            $product = $queryBuilder
                ->select('product')
                ->from(Product::class, 'product')
                ->innerJoin('product.categories', 'category')
                ->where('category.id = :categoryId')
                ->setParameter('categoryId', $categoryId)
                ->getQuery()
                ->getResult();
        } catch (DBALException|NonUniqueResultException $exception) {
            throw new InfraException($exception->getMessage(), $exception);
        }

        return $product;
    }
}