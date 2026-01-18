<?php

namespace App\Controller\Api;

use App\Controller\BaseController;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route(path: '/api/uuid', name: 'app_uuid', methods: ['GET'])]
#[Cache(maxage: 0, smaxage: 0, mustRevalidate: true, noStore: true)]
class UuidController extends BaseController
{
    public function __invoke(#[MapQueryParameter] int $count = 1): array|string
    {
        if ($count > 1) {
            $count = min($count, 50);

            return array_map(fn() => Uuid::v7()->toString(), range(1, $count));
        }

        return Uuid::v7()->toString();
    }
}
