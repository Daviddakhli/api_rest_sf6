<?php

declare(strict_types=1);

namespace App\Application\Service\Category;

use App\Domain\Entity\Category;

class CreateCategoryHandler
{
    public function create(string $name): Category
    {
        return (new Category())
            ->setName($name);
    }
}
