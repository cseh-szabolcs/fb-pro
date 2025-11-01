<?php

namespace App\EventListener;

use App\Attribute\Request\XhrRequest;
use App\Attribute\Security\Grant;
use App\Component\Reader\AttributeReader;
use App\Security\AuthProvider;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $this->checkXhrRequest($controller, $event);
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

    private function checkXhrRequest(callable $controller, ControllerEvent $event): void
    {
        [$controllerObject, $method] = $controller;
        $attr = AttributeReader::fromMethod($controllerObject, $method, XhrRequest::class);

        if (!$attr || !$event->isMainRequest()) {
            return;
        }

        if (!$event->getRequest()->isXmlHttpRequest()) {
            $event->setController(static fn () => new Response('Page not found.', 404));
        }
    }
}
