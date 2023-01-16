<?php

declare(strict_types=1);

namespace Framework\Validation\Filter;

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
