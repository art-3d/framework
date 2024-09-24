<?php

declare(strict_types=1);

namespace Command;

use Framework\Command\Command;
use Framework\Command\Input\InputInterface;
use Framework\Command\Output\OutputInterface;

class GenerateMigrationCommand extends Command
{
    public function configure(): void
    {
        $this
            ->setName('migration:generate')
            ->setDescription('Generate a blank migration class')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        echo 'generate migration executed' . PHP_EOL;

        return self::SUCCESS;
    }
}
