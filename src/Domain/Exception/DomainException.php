<?php

declare(strict_types=1);

namespace App\Domain\Exception;

abstract class DomainException extends \DomainException implements DomainExceptionInterface
{
    public function __construct(
        string     $message,
        private    readonly string $errorCode,
        \Throwable $previous = null
    )
    {
        parent::__construct($message, 0, $previous);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
