<?php

namespace App\Controller;

use App\Contracts\ToArrayInterface;
use App\Entity\User;
use App\Security\AuthProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
        mixed $data,
        array|int $groups = [],
        array|int $headers = [],
        array|int $context = [],
        int $status = 200,
    ): JsonResponse {
        if ($data instanceof ToArrayInterface) {
            $data = $data->toArray();
        }

        if (is_int($groups)) {
            $status = $groups;
            $groups = [];
        }

        if (is_int($headers)) {
            $status = $headers;
            $headers = [];
        }

        if (is_int($context)) {
            $status = $context;
            $context = [];
        }

        return $this->json($data, $status, $headers, array_merge(
            ['groups' => array_merge($groups, ['default'])],
            $context,
        ));
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

    protected function createPRGResponse(mixed $data = true): Response
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $this->addFlash('app_form_prg', $data ?? true);

        return new RedirectResponse($request->getRequestUri());
    }

    protected function isPRGResponse(): mixed
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        return $request->getSession()->getFlashBag()->get('app_form_prg')[0] ?? null;
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
