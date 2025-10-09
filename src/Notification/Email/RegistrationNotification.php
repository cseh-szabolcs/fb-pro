<?php

namespace App\Notification\Email;

use App\Event\Auth\RegistrationEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final readonly class RegistrationNotification extends AbstractNotification
{
    public function __invoke(RegistrationEvent $event): void
    {
        $this->mailer->send(
            to: $event->user,
            subject: 'Password reset',
            template: 'email/auth/registration.html.twig',
            data: [
                'token' => $event->token->getUuid()->toString(),
                'user' => $event->user,
            ],
        );
    }
}
