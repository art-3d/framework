<?php

declare(strict_types=1);

namespace Framework\Command\Input;

use Framework\Exception\InvalidArgumentException;

class InputOption
{
    public const VALUE_OPTIONAL = 1;
    public const VALUE_REQUIRED = 2;

    public function __construct(
        private string $name,
        private ?string $shortcut = null,
        private ?int $mode = null,
        private ?string $description = null,
        private int|string|null $default = null,
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException('An option name cannot be empty.');
        }

        if (is_null($shortcut) && empty($shortcut)) {
            throw new InvalidArgumentException('An option shortcut cannot be empty.');
        }
    }
}
