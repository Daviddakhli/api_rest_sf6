<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Exception;

use App\Infrastructure\Exception\InfraException;
use Throwable;

class DatabaseAccessException extends InfraException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), $previous);
    }
}
