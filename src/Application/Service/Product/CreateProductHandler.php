<?php

declare(strict_types=1);

namespace App\Application\Service\Product;

use App\Domain\Entity\Product;

class CreateProductHandler
{
    public function create(string $name, int $stock, string $price, array $categoryList): Product
    {
        $product = (new Product())
            ->setName($name)
            ->setStock($stock)
            ->setPrice($price);

        foreach ($categoryList as $category) {
            $product->addCategory($category);
        }

        return $product;
    }
}
