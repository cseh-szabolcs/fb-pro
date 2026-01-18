<?php

namespace App\Controller;

use App\App;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route(path: '/batch', name: 'app_batch_request', methods: ['POST'])]
class BatchController extends AbstractController
{
    public function __construct(
        private readonly App $app,
    ) {}

    public function __invoke(Request $mainRequest, HttpKernelInterface $httpKernel): Response
    {
        $batches = json_decode($mainRequest->getContent(), true) ?: [];
        $responses = [];
        foreach ($batches as $data) {
            try {
                $request = self::createRequest($data, $mainRequest);
                $response = $httpKernel->handle($request);
                $responses[] = [
                    'method' => $request->getMethod(),
                    'path' => $request->getRequestUri(),
                    'code' => $response->getStatusCode(),
                    'body' => $response->getContent(),
                ];

            } catch (Throwable $e) {
                $responses[] = new Response($this->app->isDev()
                    ? $e->getMessage()
                    : null,
                401);
            }
        }

        return $this->json($responses);
    }

    private static function createRequest(array $data, Request $request): Request
    {
        assert(
            is_string($data['path'] ?? null)
            && is_string($data['method'] ?? null)
        );

        $cookies = $request->cookies->all();
        $server = $request->server->all();
        $body = isset($data['body']) ? json_encode($data['body']) : null;

        $subRequest = Request::create($data['path'], $data['method'], [], $cookies, [], $server, $body);

        foreach ($request->headers->all() as $name => $values) {
            foreach ($values as $value) {
                $subRequest->headers->set($name, $value);
            }
        }

        return $subRequest;
    }
}
