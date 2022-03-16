<?php

declare(strict_types=1);

namespace App\Domain\Exception;

interface DomainExceptionInterface extends \Throwable
{
    public function getErrorCode(): string;
}
