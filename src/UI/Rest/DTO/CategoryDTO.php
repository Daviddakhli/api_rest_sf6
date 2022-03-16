<?php

namespace App\UI\Rest\DTO;

use App\Domain\Entity\Category;

class CategoryDTO
{
    public function __construct(
        public int    $id,
        public string $name
    )
    {
    }

    public static function fromCategory(Category $category): self
    {
        return new self(
            $category->getId(),
            $category->getName()
        );
    }
}