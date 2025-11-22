<?php

namespace App\Controller\Editor;

use App\Attribute\ArgumentResolver\MapEntityUuid;
use App\Controller\BaseController;
use App\Entity\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route(path: '/editor/forms/{uuid}', name: 'app_editor_forms_')]
class FormsController extends BaseController
{
    #[Route(path: '/index', name: 'index', methods: ['GET'])]
    public function index(#[MapEntityUuid] Form $form, RouterInterface $router,): Response
    {
        return $this->render('editor/forms.html.twig', [
            'dataSrc' => $router->generate('app_editor_forms_data', ['uuid' => $form->getUuid()->toString()]),
        ]);
    }

    #[Route(path: '/data', name: 'data', methods: ['GET'])]
    public function data(#[MapEntityUuid] Form $form): Response
    {
        return $this->toJson($form->getDraftVersion(), ['editor']);
    }
}
