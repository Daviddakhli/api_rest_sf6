<?php

declare(strict_types=1);

namespace App\Utils\Serializer\Normalizer;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer as SymfonyConstraintViolationListNormalizer;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer extends SymfonyConstraintViolationListNormalizer
{
    /**
     * @param ConstraintViolationListInterface $object
     * @throws ExceptionInterface
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $normalizedList = parent::normalize($object, $format, $context);

        $normalizedList['violations'] = array_map(
            function (array $normalizedViolation, ConstraintViolationInterface $violation): array {
                return $normalizedViolation + ['context' => $violation->getParameters()];
            },
            $normalizedList['violations'],
            iterator_to_array($object)
        );

        return $normalizedList;
    }
}
