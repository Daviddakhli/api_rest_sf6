<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractEntityRepository
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }
}
