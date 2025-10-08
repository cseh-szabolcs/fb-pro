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
                ->html($this->render($template, $data))
                ->text($this->render($template, $data, true))
            ;

            $this->mailer->send($email);
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to send welcome email.', previous: $e);
        }
    }

    private function render(string $template, array $context = [], bool $text = false): string
    {
        if ($text) {
            $template = str_replace('.html.twig', '.text.twig', $template);
        }

        try {
            return $this->twig->render($template, $context);
        } catch (Throwable $e) {
            throw new RuntimeException(sprintf('Failed to render email template "%s".', $template), previous: $e);
        }
    }
}
