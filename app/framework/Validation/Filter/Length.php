<?php

namespace Framework\Validation\Filter;

use Framework\Validation\Filter\Filter;

class Length extends Filter implements FilterInterface
{
    public function __construct(private $min, private $max)
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
