<?php

declare(strict_types=1);

namespace Framework\Validation\Filter;

abstract class Filter
{
    protected string $message;

    public function getMessage(): string
    {
        return $this->message;
    }
}
