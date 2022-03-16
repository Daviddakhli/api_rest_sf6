<?php

namespace App\UI\Rest\DTO;

use App\Domain\Entity\Category;
use App\Domain\Entity\Product;

class ProductItemDTO
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $price,
        public int    $stock,
        public array  $categories
    )
    {
    }

    public static function fromProduct(Product $product): self
    {
        $arraySelf = [];
        /** @var Category $category */
        foreach ($product->getCategories() as $category) {
            $arraySelf[] = CategoryDTO::fromCategory($category);
        }

        return new self(
            $product->getId(),
            $product->getName(),
            $product->getPrice(),
            $product->getStock(),
            $arraySelf
        );
    }
}