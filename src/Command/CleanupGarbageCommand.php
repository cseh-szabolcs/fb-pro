<?php

namespace App\Command;

use App\Garbage\CleanupGarbageInterface;
use IteratorAggregate;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsCommand(
    name: 'app:garbage:cleanup',
    description: 'Add a short description for your command',
)]
class CleanupGarbageCommand extends AbstractCommand
{
    public function __construct(
        /** @var CleanupGarbageInterface[] */
        #[AutowireIterator(tag: 'app.cleanup_garbage.worker')]
        private readonly IteratorAggregate $workers,
    ) {
        parent::__construct();
    }

    public function __invoke(
        // todo: this should work, but it doesn't' :-(
        // #[AutowireIterator(tag: 'app.cleanup_garbage.worker')] IteratorAggregate $workers,
    ): int
    {
        foreach ($this->workers as $worker) {
            if ($worker instanceof CleanupGarbageInterface) {
                $worker($this->io);
            }
        }

        $this->io->writeln('CleanUp ... :o) ');

        return Command::SUCCESS;
    }
}
