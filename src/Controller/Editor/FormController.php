<?php

namespace App\Controller\Editor;

use App\Attribute\ArgumentResolver\MapEntityUuid;
use App\Controller\BaseController;
use App\Entity\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/editor/form/{uuid}', name: 'app_editor_forms_')]
class FormController extends BaseController
{
    #[Route(path: '/index', name: 'index', methods: ['GET'])]
    public function index(#[MapEntityUuid] Form $form): Response
    {
        return $this->render('editor/index.html.twig', [
            'id' => $form->getUuid()->toString(),
            'type' => 'form',
            'locale' => $this->app->locale(),
        ]);
    }

    #[Route(path: '/data', name: 'data', methods: ['GET'])]
    public function data(#[MapEntityUuid] Form $form): Response
    {
        return $this->toJson($form->getDraftVersion(), ['editor', 'editor-get']);
    }
}
