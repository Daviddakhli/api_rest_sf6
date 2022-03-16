<?php

declare(strict_types=1);

namespace App\Utils\Exception;

trait HttpProblemTrait
{
    /** @var int */
    private $statusCode = 400;

    /** @var array */
    private $headers = [];

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
