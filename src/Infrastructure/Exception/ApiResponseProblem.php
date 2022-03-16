<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use App\Domain\Exception\InfraExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiResponseProblem extends HttpException implements InfraExceptionInterface
{
    public function __construct(
        private    readonly ?ResponseInterface $response,
        int        $statusCode = 500,
        ?string    $message = null,
        \Exception $previous = null,
        array      $headers = [],
        ?int       $code = 0
    )
    {
        $statusCode = isset($response) ? $response->getStatusCode() : $statusCode;
        parent::__construct(
            $statusCode,
            $message,
            $previous,
            $headers,
            $code
        );
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
