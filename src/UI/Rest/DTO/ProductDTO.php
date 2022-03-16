<?php

namespace App\UI\Rest\DTO;

use App\Domain\Entity\Product;

class ProductDTO
{
    public function __construct(
        public array $arraySelf
    )
    {
    }

    public static function fromProduct(array $products): self
    {
        $arraySelf = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $arraySelf[] = ProductItemDTO::fromProduct($product);
        }
        return new self($arraySelf);
    }
}