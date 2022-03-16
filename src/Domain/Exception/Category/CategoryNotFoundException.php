<?php

declare(strict_types=1);

namespace App\Domain\Exception\Category;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\ErrorCodes;

class CategoryNotFoundException extends DomainException
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, ErrorCodes::CATEGORY_NOT_FOUND, $previous);
    }

    public static function forCategoryId(int $categoryId, \Throwable $previous = null): self
    {
        return new self(
            sprintf('Unable to find a category for id "%d"', $categoryId),
            $previous
        );
    }
}