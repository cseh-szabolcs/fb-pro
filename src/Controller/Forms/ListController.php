<?php

namespace App\Controller\Forms;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/forms', name: 'app_forms_')]
class ListController extends BaseController
{
    #[Route(name: 'index')]
    public function login(): Response
    {
        return $this->render('pages/forms/index.html.twig');
    }

    #[Route(path: '/fetch', name: 'fetch')]
    public function fetch(): JsonResponse
    {
        return $this->toJson(['items' => ['item1', 'item2', 'item3'], 'count' => 3]);
    }
}
