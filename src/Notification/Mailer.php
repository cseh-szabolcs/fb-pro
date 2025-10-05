<?php

namespace App\Notification;

use App\Contracts\EmailAwareInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Throwable;
use Twig\Environment;

final readonly class Mailer
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig,
        #[Autowire('%env(APP_MAILER_FROM_EMAIL)%')]
        private string $fromEmail,
    ) {}

    public function send(
        string|EmailAwareInterface $to,
        string $subject,
        string $template,
        array $data = [],
    ): void
    {
        if ($to instanceof EmailAwareInterface) {
            $to = $to->getEmail();
        }

        try {
            $email = (new Email())
                ->from($this->fromEmail)
                ->to($to)
                ->subject($subject)
                ->text($this->render($template, 'text', $data))
                ->html($this->render($template, 'html', $data));

            $this->mailer->send($email);
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to send welcome email.', previous: $e);
        }
    }

    private function render(string $template, string $type, array $context = []): string
    {
        try {
            return $this->twig->render(sprintf('email/%s.%s.twig', trim($template, '/'), $type), $context);
        } catch (Throwable $e) {
            throw new RuntimeException(sprintf('Failed to render email template "%s".', $template), previous: $e);
        }
    }
}
