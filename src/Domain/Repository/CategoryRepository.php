<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Category;
use App\Domain\Exception\Category\CategoryNotFoundException;
use App\Domain\Exception\InfraExceptionInterface;

interface CategoryRepository
{

    /**
     * @throws CategoryNotFoundException
     * @throws InfraExceptionInterface
     */
    public function save(Category $category): void;

    /**
     * @throws CategoryNotFoundException
     * @throws InfraExceptionInterface
     */
    public function findById(int $categoryId): Category;

    /**
     * @throws CategoryNotFoundException
     * @throws InfraExceptionInterface
     */
    public function findByListId(array $categoryListId): array;
}