<?php

namespace App\Command;

use App\Service\Schedule;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:schedule')]
class ScheduleCommand extends Command
{
    public function __construct(private Schedule $schedule)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->schedule->applySchedule();

        return Command::SUCCESS;
    }
}
