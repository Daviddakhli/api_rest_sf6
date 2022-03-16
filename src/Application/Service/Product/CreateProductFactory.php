<?php

declare(strict_types=1);

namespace App\Application\Service\Product;

use App\Domain\Entity\Product;

class CreateProductFactory
{
    public function __construct(private readonly CreateProductHandler $createProductHandler)
    {
    }

    public function create(
        string $name,
        int    $stock,
        string $price,
        array  $categoryList
    ): Product
    {
        return $this->createProductHandler->create($name, $stock, $price, $categoryList);
    }
}
