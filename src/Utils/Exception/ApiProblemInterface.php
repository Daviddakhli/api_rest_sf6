<?php

declare(strict_types=1);

namespace App\Utils\Exception;

/**
 * This interface is use to specify logic exception or constraint validation.
 */
interface ApiProblemInterface
{
    /**
     * Return a string that identify the type of error.
     *
     * Example: FORBIDDEN
     */
    public function getAppCode(): string;

    /**
     * Get the problem message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Get a context specifying the problem.
     *
     * @return iterable<string,string>|null
     */
    public function getContext(): ?iterable;
}
