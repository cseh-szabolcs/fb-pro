<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use App\Constants\Env;
use App\Constants\Http;
use App\Entity\User;
use App\Security\TokenVerifier;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Uid\Exception\InvalidArgumentException;

class TokenAuthenticator extends AbstractAuthenticator
{
    private bool $dev;

    private ?string $token = null;

    private ?string $newToken = null;

    public function __construct(
        private readonly TokenVerifier $tokenVerifier,
        #[Autowire('%env(APP_ENV)%')] string $env,
    ) {
        $this->dev = $env === Env::Dev->value;
    }

    public function supports(Request $request): ?bool
    {
        $this->token = $this->getAuthToken($request);

        return is_string($this->token);
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        try {
            return new SelfValidatingPassport(
                new UserBadge(
                    $this->token,
                    $this->verifyToken(...),
                )
            );

        } catch (InvalidArgumentException) {
            throw new AuthenticationException('Missing Bearer token.');
        }
    }

    public function verifyToken(string $token): User
    {
        $token = $this->tokenVerifier->verify($token);
        $current = $token->__toString();

        if ($current !== $this->token) {
            $this->newToken = $current;
        }

        return $token->getOwner();
    }

    #[AsEventListener]
    public function onResponse(ResponseEvent $event): void
    {
        if (is_string($this->newToken)) {
            $event->getResponse()->headers->set(Http::HEADER_AUTH_TOKEN, $this->newToken);
        }
    }

    private function getAuthToken(Request $request): ?string
    {
        if ($token = $request->headers->get('Authorization')) {
            if (str_starts_with($token, 'Bearer ')) {
                return substr($token, 7);
            }
        }

        if ($this->dev && $token = $request->query->get('bearer')) {
            return $token;
        }

        return null;
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        // Für APIs meist: einfach Request weiterlaufen lassen
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Für APIs: 401 JSON, für "nur User laden" kannst du auch null zurückgeben
        return null;
    }
}
