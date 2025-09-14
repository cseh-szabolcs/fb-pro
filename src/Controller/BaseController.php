<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Security\AuthProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class BaseController extends AbstractController
{
    use TargetPathTrait;

    public function newResponse(int $status = Response::HTTP_NO_CONTENT, string $content = ''): Response
    {
        return new Response($content, $status);
    }

    protected function toJson(
        array|object $data,
        array $context = [],
        array $headers = [],
        int $status = 200,
    ): JsonResponse {
        return $this->json($data, $status, $headers, $context);
    }

    protected function getUser(): ?User
    {
        return $this->getAuth()->getUser();
    }

    protected function isAuthenticated(): bool
    {
        return $this->getAuth()->isAuthenticated();
    }

    protected function getAuth(): AuthProvider
    {
        return $this->container->get('app_auth');
    }

    protected function getRouter(): RouterInterface
    {
        return $this->container->get('router');
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

    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            'app_em' => EntityManagerInterface::class,
            'app_auth' => AuthProvider::class,
        ];
    }
}
