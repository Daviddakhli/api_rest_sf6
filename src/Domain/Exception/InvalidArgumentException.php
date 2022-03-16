<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class InvalidArgumentException extends DomainException
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, ErrorCodes::INVALID_ARGUMENT, $previous);
    }
}
