<?php

namespace App\EventListener;

use App\Component\Reader\AttributeReader;
use App\Exception\SecurityException;
use App\Security\Attribute\Grant;
use App\Security\AuthProvider;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        $this->checkSoftGranted($controller, $event);
    }

    private function checkSoftGranted(callable $controller, ControllerEvent $event): void
    {
        [$controllerObject, $method] = $controller;
        $attr = AttributeReader::fromMethod($controllerObject, $method, Grant::class);

        if (!$attr) {
            return;
        }

        if (!$this->auth->hasRole($attr->role, null, $attr->strict)) {
            if ($attr->throw) {
                throw new AccessDeniedException('Access denied');
            }

            $url = $this->urlGenerator->generate($attr->redirect, $attr->params);
            $event->setController(static fn () => new RedirectResponse($url));
        }
    }
}
