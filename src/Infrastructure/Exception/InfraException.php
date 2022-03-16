<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use App\Domain\Exception\InfraExceptionInterface;

class InfraException extends \RuntimeException implements InfraExceptionInterface
{
    public function __construct(string $message = '', \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
