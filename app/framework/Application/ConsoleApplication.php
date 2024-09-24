<?php

declare(strict_types=1);

namespace Framework\Application;

use Framework\Command\Command;
use Framework\Command\Input\InputInterface;
use Framework\Command\Input\InputOption;
use Framework\Command\Output\Output;
use Framework\Command\Output\OutputInterface;
use Framework\DI\Container;

final class ConsoleApplication extends Application
{
    /** @var Command[] $commands */
    private array $commands = [];

    private InputInterface $input;
    private OutputInterface $output;

    public function __construct(
        private Container $container,
        private array $arguments,
    ) {
        $container->add(self::class, $this);

        $this->input = $container->make(InputOption::class);
        $this->output = $container->make(Output::class);
    }

    public function buildCommands(): void
    {
        foreach ($this->container->getParameter('commands') as $commandName) {
            /** @var Command $command */
            $command = $this->container->make($commandName);
            $command->configure();
            $this->commands[$command->getName()] = $command;
        }
    }

    public function run(): void
    {
        if (count($this->arguments) < 2) {
            $this->displayHelp();

            return;
        }

        $commandName = $this->arguments[1];
        if (!isset($this->commands[$commandName])) {
            $this->displayHelp();

            return;
        }

        $command = $this->commands[$commandName];
        $command->configure();

        $exitCode = $command->execute($this->input, $this->output);

        exit($exitCode);
    }

    private function displayHelp(): void
    {
        echo 'The list of commands:' . PHP_EOL;
        foreach ($this->commands as $command) {
            echo $command->getName() . ' | ' . $command->getDescription() . PHP_EOL;
        }
    }
}
