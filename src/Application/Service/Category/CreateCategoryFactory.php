<?php

declare(strict_types=1);

namespace App\Application\Service\Category;

use App\Domain\Entity\Category;

class CreateCategoryFactory
{
    public function __construct(private readonly CreateCategoryHandler $createCategoryHandler)
    {
    }

    public function create(string $name): Category
    {
        return $this->createCategoryHandler->create($name);
    }
}
