<?php

declare(strict_types=1);

namespace App\UI\Rest\Exception;

use App\Domain\Exception\DomainExceptionInterface;
use App\Utils\Exception\ApiProblemInterface;
use App\Utils\Exception\ApiProblemTrait;
use App\Utils\Exception\HttpProblemTrait;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class RestException extends \Exception implements ApiProblemInterface, HttpExceptionInterface
{
    use ApiProblemTrait;
    use HttpProblemTrait;

    /**
     * @param string[] $context
     * @param string[] $headers
     */
    public function __construct(
        string     $message,
        int        $statusCode,
        array      $headers = [],
        array      $context = [],
        \Throwable $previous = null
    )
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->context = $context;
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * @param string[] $context
     * @param string[] $headers
     */
    public static function fromDomainException(
        DomainExceptionInterface $e,
        int                      $statusCode,
        array                    $headers = [],
        array                    $context = []
    ): self
    {
        $self = new self($e->getMessage(), $statusCode, $headers, $context, $e);
        $self->setAppCode($e->getErrorCode());

        return $self;
    }

    public function setAppCode(string $appCode): self
    {
        $this->appCode = mb_strtoupper($appCode);

        return $this;
    }
}
