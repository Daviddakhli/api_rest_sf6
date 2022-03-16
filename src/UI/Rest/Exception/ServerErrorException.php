<?php

declare(strict_types=1);

namespace App\UI\Rest\Exception;

use App\Domain\Exception\InfraExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class ServerErrorException extends RestException
{
    /**
     * @param string[] $context
     * @param string[] $headers
     */
    public static function fromInfraException(
        InfraExceptionInterface $e,
        int                     $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array                   $headers = [],
        array                   $context = []
    ): self
    {
        return new self('Technical error', $statusCode, $headers, $context, $e);
    }

    /**
     * @param string[] $context
     * @param string[] $headers
     */
    public static function fromThrowable(
        \Throwable $e,
        int        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array      $headers = [],
        array      $context = []
    ): self
    {
        $e = new self(sprintf('Unknown error of type %s', $e::class), $statusCode, $headers, $context, $e);

        return $e;
    }
}
