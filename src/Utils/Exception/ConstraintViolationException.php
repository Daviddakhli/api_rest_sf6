<?php

declare(strict_types=1);

namespace App\Utils\Exception;

use DomainException;
use App\Utils\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationException extends DomainException implements ApiProblemInterface, HttpExceptionInterface
{
    use ApiProblemTrait;
    use HttpProblemTrait;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->appCode = 'CONSTRAINT_VIOLATION';
        $this->context = (new ConstraintViolationListNormalizer())->normalize($violationList);
        parent::__construct($this->context['detail']);
    }
}
