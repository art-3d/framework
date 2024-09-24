<?php

declare(strict_types=1);

namespace Framework\Command;

use Framework\Command\Input\InputInterface;
use Framework\Command\Input\InputOption;
use Framework\Command\Output\OutputInterface;
use InvalidArgumentException;

abstract class Command
{
    public const SUCCESS = 0;
    public const FAILURE = 1;
    public const INVALID = 2;

    private string $name = '';
    private string $description = '';
    private array $options = [];

    abstract public function configure(): void;

    abstract public function execute(InputInterface $input, OutputInterface $output): int;

    public function setName(string $name): self
    {
        $this->validateName($name);

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function addOption(string $name, string $shortcut = null, int $mode = null, string $description = null, int|string $default = null): self
    {
        $this->options[] = new InputOption($name, $shortcut, $mode, $description, $default);

        return $this;
    }

    private function validateName(string $name): void
    {
        if (!preg_match('/^[^\:]++(\:[^\:]++)*$/', $name)) {
            throw new InvalidArgumentException(sprintf('Command name "%s" is invalid.', $name));
        }
    }
}
