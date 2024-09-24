<?php

declare(strict_types=1);

namespace Command;

use Framework\Command\Command;
use Framework\Command\Input\InputInterface;
use Framework\Command\Output\OutputInterface;
use Framework\DataBase\Connection;

class MigrateCommand extends Command
{
    public function __construct(private Connection $connection, private string $dbStructure)
    {
    }

    public function configure(): void
    {
        $this
            ->setName('migration:migrate')
            ->setDescription('Execute migrations.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $stmt = $this->connection->pdo()->prepare($this->dbStructure);
        $stmt->execute();

        return self::SUCCESS;
    }
}
