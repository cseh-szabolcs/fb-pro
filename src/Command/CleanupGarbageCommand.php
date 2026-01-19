<?php

namespace App\Command;

use App\Garbage\CleanupGarbageInterface;
use IteratorAggregate;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'app:garbage:cleanup',
    description: 'Add a short description for your command',
)]
class CleanupGarbageCommand extends AbstractCommand
{
    private readonly IteratorAggregate $workers;

    public function __invoke(): int
    {
        $this->io->title('Nice night for a walk ey, now cleaning right?');

        foreach ($this->workers as $worker) {
            if ($worker instanceof CleanupGarbageInterface) {
                $this->io->write('Execute worker ' . $worker::class . ' ... ');
                $worker($this->io);
                $this->io->writeln('<info>done</info>!');
            }
        }

        $this->io->success('Now its clean :)');

        return Command::SUCCESS;
    }

    #[Required]
    public function setWorkers(
        #[AutowireIterator(tag: 'app.cleanup_garbage.worker')] $workers,
    ): void
    {
        $this->workers = $workers;
    }
}
