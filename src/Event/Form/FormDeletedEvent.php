<?php

namespace App\Event\Form;

use App\Entity\Form;
use Symfony\Contracts\EventDispatcher\Event;

final class FormDeletedEvent extends Event
{
    public function __construct(
        public readonly Form $form,
    ) {}
}
