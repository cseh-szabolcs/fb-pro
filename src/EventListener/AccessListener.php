<?php

namespace App\EventListener;

use App\Security\Attribute\GuestGranted;
use App\Security\AuthProvider;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener]
final readonly class AccessListener
{
    public function __construct(
        private AuthProvider $auth,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        [$controllerObject, $method] = $controller;

        $refMethod = new ReflectionMethod($controllerObject, $method);
        $attr = $refMethod->getAttributes(GuestGranted::class)[0] ?? null;

        if (!$attr) {
            $refClass = new ReflectionClass($controllerObject);
            $attr = $refClass->getAttributes(GuestGranted::class)[0] ?? null;
        }

        if (!$attr) {
            return;
        }

        if ($this->auth->isAuthenticated()) {
            /** @var GuestGranted $config */
            $config = $attr->newInstance();
            $url = $this->urlGenerator->generate($config->redirectRoute ?? 'app_home', $config->redirectRouteParams);
            $event->setController(static fn () => new RedirectResponse($url));
        }
    }
}
