<?php

namespace App\Controller\Editor;

use App\Contracts\Editor\FixtureFactoryInterface;
use App\Controller\BaseController;
use App\Factory\Editor\FormFixturesFactory;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/editor/fixtures/{type}', name: 'app_editor_fixtures')]
class FixturesController extends BaseController
{
    public function __construct(
        private readonly FormFixturesFactory $formFixturesFactory,
    )
    {}

    public function __invoke(string $type, FormFixturesFactory $fixturesFactory): JsonResponse
    {
        try {
            $data = $this->getFactory($type)->create();

            return $this->toJson($data, ['fixture', 'editor', 'editor-get']);

        } catch (InvalidArgumentException) {
            throw $this->createNotFoundException();
        }
    }

    private function getFactory(string $type): FixtureFactoryInterface
    {
        return match ($type) {
            'form' => $this->formFixturesFactory,
            default => throw new InvalidArgumentException(),
        };
    }
}
