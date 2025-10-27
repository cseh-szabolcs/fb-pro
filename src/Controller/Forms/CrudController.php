<?php

declare(strict_types=1);

namespace App\Controller\Forms;

use App\Form\Data\Forms\CreateData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
# use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/forms', name: 'app_forms_')]
class CrudController extends AbstractController
{
    #[Route('/create', name: 'create', methods: 'POST')]
    public function index(): Response
    {
        return $this->render('create/index.html.twig');
    }
}
