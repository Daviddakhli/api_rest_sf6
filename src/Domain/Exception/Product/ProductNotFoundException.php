<?php

namespace App\Domain\Exception\Product;

use Exception;
use Throwable;

/**
 * Class ProductNotFoundException
 * @package App\Domain\Exception
 */
class ProductNotFoundException extends Exception
{
    /**
     * ProductNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "Product not found", int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}