<?php

namespace App\Notification\Email;

use App\Event\Auth\PasswordResetEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final readonly class PasswordResetNotification extends AbstractNotification
{
    public function __invoke(PasswordResetEvent $event): void
    {
        $this->mailer->send(
            to: $event->user,
            subject: 'Password reset',
            template: 'email/auth/password_reset.html.twig',
            data: [
                'token' => $event->token->getUuid()->toString(),
                'user' => $event->user,
            ],
        );
    }
}
