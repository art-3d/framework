<?php

declare(strict_types=1);

namespace Framework\Validation\Filter;

interface FilterInterface
{
    public function isValid($entity);

    public function getMessage(): string;
}
