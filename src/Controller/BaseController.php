<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\DtoProvider;
use App\Entity\User;
use App\Model\StorageFile;
use App\Security\SecurityProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class BaseController extends AbstractController
{
    use TargetPathTrait;

    public function emptyResponse(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            'app_em' => EntityManagerInterface::class,
            'app_security' => SecurityProvider::class,
            'app_dto' => DtoProvider::class,
        ];
    }

    protected function toDto(
        array|object $data,
        array $context = [],
        array $headers = [],
        int $status = 200,
    ): JsonResponse {
        $data = $this->getDtoProvider()->createOutput($data, $context);

        return $this->json($data, $status, $headers, $context);
    }

    protected function toJson(
        array|object $data,
        array $context = [],
        array $headers = [],
        int $status = 200,
    ): JsonResponse {
        return $this->json($data, $status, $headers, $context);
    }

    public function toStream(StorageFile $file): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($file) {
            $stream = $file->getContent()->asStream();
            fpassthru($stream);
        });

        $response->headers->set('Content-Type', sprintf('%s; charset=utf-8', $file->mimeType));
        $response->headers->set('Content-Disposition', sprintf('inline; filename="document.%s"', $file->getExtension()));
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    protected function getUser(): ?User
    {
        return $this->getSecurity()->getUser();
    }

    protected function isAuthenticated(): bool
    {
        return $this->getSecurity()->isAuthenticated();
    }

    protected function getSecurity(): SecurityProvider
    {
        return $this->container->get('app_security');
    }

    protected function getRouter(): RouterInterface
    {
        return $this->container->get('router');
    }

    protected function getDtoProvider(): DtoProvider
    {
        return $this->container->get('app_dto');
    }

    protected function em(): EntityManagerInterface
    {
        return $this->container->get('app_em');
    }

    protected function saveEntity(object $entity): void
    {
        $this->em()->persist($entity);
        $this->em()->flush();
    }

    protected function removeEntity(object $entity): void
    {
        $this->em()->remove($entity);
        $this->em()->flush();
    }
}
