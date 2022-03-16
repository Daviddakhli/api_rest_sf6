<?php

declare(strict_types=1);

namespace App\Utils\Validation;

use App\Utils\Exception\ConstraintViolationException;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    /** @var ValidatorInterface */
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $dto
     * @param array<string|GroupSequence> $groups The validation groups to validate against. If none is given, "Default" is assumed
     */
    public function validate(object $dto, array $groups = []): void
    {
        $violations = $this->validator->validate($dto, null, $groups ?: null);

        if (\count($violations) > 0) {
            throw new ConstraintViolationException($violations);
        }
    }
}
