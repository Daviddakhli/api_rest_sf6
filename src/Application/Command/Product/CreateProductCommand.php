<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductCommand implements Command
{
    public function __construct(
        #[Assert\NotNull(message: "The 'categoryList' should not be null")] private readonly array $categoryList,
        #[Assert\NotNull(message: "The 'name' should not be null")] private readonly string $name,
        #[Assert\NotNull(message: "The 'price' should not be null")] private readonly string $price,
        #[Assert\NotNull(message: "The 'stock' should not be null")] private readonly int $stock
    ) {
    }


    public function getCategoryList(): array
    {
        return $this->categoryList;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}