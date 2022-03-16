<?php

declare(strict_types=1);

namespace App\Domain\Exception;

final class ErrorCodes
{
    /** Category */
    public const CATEGORY_NOT_FOUND = 'CATEGORY_NOT_FOUND';
    public const CATEGORY_ALREADY_CREATED = 'CATEGORY_ALREADY_CREATED';

    /** Domain **/
    public const INVALID_ARGUMENT = 'INVALID_ARGUMENT';
}
