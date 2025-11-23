<?php

namespace App\EventListener;

use App\App;
use App\Constants\Http;
use App\Security\Authenticator\TokenAuthenticator;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class CorsListener
{
    const ALLOWED_HEADERS = [
        'Cookie',
        'Authorization',
        'Origin',
        'Content-Type',
        'Content-Length',
        'Accept',
        'Access-Control-Request-Method',
        'X-Requested-With',
        Http::HEADER_AUTH_TOKEN,
    ];

    const ALLOWED_METHODS = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'OPTIONS',
    ];

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

        $methods = implode(', ', self::ALLOWED_METHODS);
        $headers = implode(', ', self::ALLOWED_HEADERS);

        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', $headers);
        $response->headers->set('Access-Control-Expose-Headers', $headers);
        $response->headers->set('Access-Control-Allow-Methods', $methods);
        $response->headers->set('Allow', $methods);
    }
}
