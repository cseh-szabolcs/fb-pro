<?php

namespace App\Command;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractCommand extends Command
{
    protected readonly InputInterface $input;
    protected readonly OutputInterface $output;
    protected readonly SymfonyStyle $io;
    protected readonly App $app;

    public function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($input, $output);
    }

    #[Required]
    public function setApp(App $app): void
    {
        $this->app = $app;
    }
}
