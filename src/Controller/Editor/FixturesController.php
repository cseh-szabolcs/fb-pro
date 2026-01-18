<?php

namespace App\Controller\Editor;

use App\Controller\BaseController;
use App\Factory\FixturesFactory;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/editor/fixtures', name: 'app_editor_fixtures')]
class FixturesController extends BaseController
{
    public function __invoke(FixturesFactory $fixturesFactory): array
    {
        return $fixturesFactory->create();
    }
}
