<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Domain\Entity\Category;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Repository\ProductRepository;

class GetProductDetailsCommandHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws ProductNotFoundException
     * @throws InfraExceptionInterface
     */
    public function handle(Category $category): array
    {
        return $this->productRepository->findByCategory($category->getId());
    }
}
