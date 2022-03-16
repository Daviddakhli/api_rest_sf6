<?php

namespace App\Domain\Exception\Product;

use Exception;
use Throwable;

/**
 * Class ProductAlreadyCreatedException
 * @package App\Domain\Exception
 */
class ProductAlreadyCreatedException extends Exception
{
    /**
     * ProductAlreadyCreatedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "Product already created.", int $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}