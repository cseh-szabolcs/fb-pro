<?php

namespace App\Traits\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\Service\Attribute\Required;

trait EventDispatcherTrait
{
    private readonly EventDispatcherInterface $eventDispatcher;

    public function dispatchEvent(Event $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    #[Required]
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
