<?php

namespace App\Garbage;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.cleanup_garbage.worker')]
interface CleanupGarbageInterface
{
    public function __invoke(SymfonyStyle $io): void;
}
