<?php

namespace App\EventListener;

use App\Component\Reader\AttributeReader;
use App\Security\Attribute\GuestGranted;
use App\Security\AuthProvider;
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

        $this->checkGuestGranted($controller, $event);
    }

    private function checkGuestGranted(callable $controller, ControllerEvent $event): void
    {
        if (!$this->auth->isAuthenticated()) {
            return;
        }

        [$controllerObject, $method] = $controller;

        if ($attr = AttributeReader::fromMethod($controllerObject, $method, GuestGranted::class)) {
            $url = $this->urlGenerator->generate($attr->redirectRoute ?? 'app_home', $attr->redirectRouteParams);
            $event->setController(static fn () => new RedirectResponse($url));
        }
    }
}
