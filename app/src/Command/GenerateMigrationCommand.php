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
            ->setName('generate:migration')
            ->setDescription('Generate a blank migration class');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {

        return self::SUCCESS;
    }
}
