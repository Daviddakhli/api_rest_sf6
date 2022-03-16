<?php

namespace App\UI\Rest\DTO;

use App\Domain\Entity\Category;
use App\Domain\Entity\Product;

class SavedProductDTO
{
    public function __construct(
        public int       $id,
        public string    $name,
        public string    $price,
        public int       $stock,
        public array     $categories,
        public \DateTime $createdAt,
    )
    {
    }

    public static function fromSavedProduct(Product $product): self
    {
        $productItemDTOs = $product->getCategories()->map(
            static fn(Category $item): CategoryDTO => CategoryDTO::fromCategory($item)
        );

        return new self(
            $product->getId(),
            $product->getName(),
            $product->getPrice(),
            $product->getStock(),
            $productItemDTOs->toArray(),
            $product->getCreatedAt()
        );
    }
}