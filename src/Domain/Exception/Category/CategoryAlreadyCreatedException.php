<?php

declare(strict_types=1);

namespace App\Domain\Exception\Category;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\ErrorCodes;

class CategoryAlreadyCreatedException extends DomainException
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, ErrorCodes::CATEGORY_ALREADY_CREATED, $previous);
    }
}