<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDatabaseTablesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:database:create-tables')
            ->setDescription('Create required tables for the application')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tablesCreateSyntaxes = [
            'accommodations' => 'CREATE TABLE IF NOT EXISTS `accommodations` (
  `id` varchar(255) NOT NULL DEFAULT \'\',
  `serializedAccommodation` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
            'reservations' => 'CREATE TABLE IF NOT EXISTS `reservations` (
  `id` varchar(255) NOT NULL DEFAULT \'\',
  `serializedReservation` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        ];

        $dbal = $this->getContainer()->get('doctrine.dbal.default_connection');
        $dbal->beginTransaction();

        $output->writeln('<info>Initializing table creation...</info>');

        foreach ($tablesCreateSyntaxes as $tableName => $createSyntax) {
            $output->writeln(sprintf('<info>* Creating table %s</info>', $tableName));
            $stmt = $dbal->prepare($createSyntax);
            $stmt->execute();
        }

        $dbal->commit();
    }
}













