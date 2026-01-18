<?php

namespace App\EventListener;

use JsonSerializable;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener(priority: 100)]
final readonly class ResponseListener
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function __invoke(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if ($result instanceof Response) {
            return;
        }

        $response = match(true) {
            is_string($result) => new Response($result),
            is_array($result) || is_object($result) => new JsonResponse($this->serializer->serialize($result, 'json')),
            default => null,
        };

        if ($response instanceof Response) {
            $event->setResponse($response);
        }
    }
}
