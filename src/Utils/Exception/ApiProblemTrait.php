<?php

declare(strict_types=1);

namespace App\Utils\Exception;

trait ApiProblemTrait
{
    /** @var string */
    private $appCode = '';

    /** @var iterable<string,string>|null */
    private $context;

    public function getAppCode(): string
    {
        return $this->appCode;
    }

    /**
     * @return iterable<string,string>|null
     */
    public function getContext(): ?iterable
    {
        return $this->context;
    }
}
