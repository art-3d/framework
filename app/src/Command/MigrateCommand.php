<?php

declare(strict_types=1);

namespace Command;

use Framework\Command\Command;
use Framework\Command\Input\InputInterface;
use Framework\Command\Output\OutputInterface;

class MigrateCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {

        return self::SUCCESS;
    }
}
