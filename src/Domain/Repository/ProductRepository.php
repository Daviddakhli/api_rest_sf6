<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Product;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Exception\Product\ProductNotFoundException;

interface ProductRepository
{
    /**
     * @throws ProductNotFoundException
     * @throws InfraExceptionInterface
     */
    public function save(Product $product);

    /**
     * @throws ProductNotFoundException
     * @throws InfraExceptionInterface
     */
    public function findByCategory(int $categoryId): array;
}
