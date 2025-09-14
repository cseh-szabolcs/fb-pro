<?php

namespace App;

use App\Constants\Env;
use App\Entity\User;
use App\Security\AuthProvider;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\EventDispatcher\Event;

final readonly class App
{
    public function __construct(
        public AuthProvider $authProvider,
        public EventDispatcherInterface $eventDispatcher,
        public RequestStack $requestStack,
        public RouterInterface $router,
        public UrlGeneratorInterface $urlGenerator,
        public EntityManagerInterface $em,
        public LoggerInterface $logger,
        public string $rootDir,
        public string $env,
    ) {
    }

    public function getCurrentPath(): string
    {
        $request = $this->getRequest();

        return $request->getBaseUrl().$request->getPathInfo();
    }

    public function isCurrentPath(string $name): bool
    {
        $this->urlGenerator->generate($name) === $this->getCurrentPath();
    }

    public function getUser(): User
    {
        return $this->authProvider->getUser();
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function getMainRequest(): Request
    {
        return $this->requestStack->getMainRequest();
    }

    public function isMainRequest(): bool
    {
        return $this->requestStack->getMainRequest() === $this->requestStack->getCurrentRequest();
    }

    public function dispatchEvent(Event $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    public function path(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    public function isDev(): bool
    {
        return Env::Dev->value === $this->env;
    }

    public function isProd(): bool
    {
        return Env::Prod->value === $this->env;
    }
}
