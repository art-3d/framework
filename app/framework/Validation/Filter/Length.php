<?php

declare(strict_types=1);

namespace Framework\Validation\Filter;

class Length extends Filter implements FilterInterface
{
    public function __construct(private int $min, private int $max)
    {
    }

    public function isValid($entity): bool
    {
        $strlen = strlen($entity);
        if ($strlen < $this->min || $strlen > $this->max) {
            $this->message = 'Wrong length';

            return false;
        }

        return true;
    }
}
