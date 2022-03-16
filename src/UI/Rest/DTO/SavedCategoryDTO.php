<?php

namespace App\UI\Rest\DTO;

use App\Domain\Entity\Category;

class SavedCategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public \DateTime $createdAt,
    ) {
    }

    public static function fromSavedCategory(Category $category): self
    {
        return new self(
            $category->getId(),
            $category->getName(),
            $category->getCreatedAt()
        );
    }
}