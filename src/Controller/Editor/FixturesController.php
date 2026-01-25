<?php

namespace App\Controller\Editor;

use App\Contracts\Editor\FixtureFactoryInterface;
use App\Controller\BaseController;
use App\Factory\Editor\FormFixturesFactory;
use InvalidArgumentException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/editor/{type}/fixtures', name: 'app_editor_fixtures')]
class FixturesController extends BaseController
{
    public function __construct(
        private readonly FormFixturesFactory $formFixturesFactory,
    )
    {}

    public function __invoke(string $type, FormFixturesFactory $fixturesFactory): array
    {
        try {
            return $this->getFactory($type)->create();
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
