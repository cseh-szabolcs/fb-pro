<?php

namespace App\Controller\Editor;

use App\Attribute\ArgumentResolver\MapEntity;
use App\Controller\BaseController;
use App\Entity\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/editor/forms/{uuid}', name: 'app_editor_forms')]
class FormsController extends BaseController
{
    public function __invoke(#[MapEntity(mapping: ['uuid' => 'uuid'])] Form $form): Response
    {
        return new Response(':o)');
    }
}
