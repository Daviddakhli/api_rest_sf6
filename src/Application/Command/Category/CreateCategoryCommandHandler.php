<?php

declare(strict_types=1);

namespace App\Application\Command\Category;

use App\Application\Service\Category\CreateCategoryFactory;
use App\Domain\Entity\Category;
use App\Domain\Exception\InfraExceptionInterface;
use App\Domain\Repository\CategoryRepository;

class CreateCategoryCommandHandler
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CreateCategoryFactory $createCategoryFactory
    )
    {
    }

    /**
     * @throws InfraExceptionInterface
     */
    public function handle(CreateCategoryCommand $command): Category
    {
        $category = $this->createCategoryFactory->create($command->getName());

        $this->categoryRepository->save($category);

        return $category;
    }
}
