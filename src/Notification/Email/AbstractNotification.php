<?php

namespace App\Notification\Email;

use App\Notification\Mailer;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract readonly class AbstractNotification
{
    public function __construct(
        protected Mailer $mailer,
        protected TranslatorInterface $translator,
    ) {}
}
