<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Service\Product\CreateProductFactory;
use App\Domain\Entity\Product;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Exception\Product\ProductNotFoundException;
use App\Domain\Repository\CategoryRepository;
use App\Domain\Repository\ProductRepository;

class CreateProductCommandHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly CreateProductFactory $createProductFactory
    )
    {
    }

    /**
     * @throws InfraExceptionInterface|ProductNotFoundException
     */
    public function handle(CreateProductCommand $command): Product
    {
        $categoryList = $this->categoryRepository->findByListId($command->getCategoryList());

        $product = $this->createProductFactory->create(
            $command->getName(),
            $command->getStock(),
            $command->getPrice(),
            $categoryList
        );

        $this->productRepository->save($product);

        return $product;
    }
}
