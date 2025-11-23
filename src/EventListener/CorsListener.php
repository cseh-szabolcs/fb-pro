<?php

namespace App\EventListener;

use App\App;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class CorsListener
{
    private bool $active;

    public function __construct(App $app)
    {
        $this->active = $app->isDev() && $app->isMainRequest();
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 9999)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->active) {
            return;
        }

        $request = $event->getRequest();
        if ($request->isMethod(Request::METHOD_OPTIONS)) {
            $response = new Response();
            $event->setResponse($response);
        }
    }

    #[AsEventListener(event: KernelEvents::RESPONSE, priority: 9999)]
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$this->active) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Cookie, Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Content-Length, Accept, Access-Control-Request-Method');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->headers->set('Allow', 'GET, POST, UPDATE, OPTIONS, PUT, DELETE');
    }
}
