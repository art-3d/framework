<?php

namespace Framework\Validation\Filter;

use Framework\Validation\Filter\Filter;

class NotBlank extends Filter implements FilterInterface
{
    public function isValid($entity)
    {
        if (empty($entity)) {
            $this->message = 'Blank value';

            return false;
        }

        return true;
    }
}