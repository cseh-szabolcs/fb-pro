<?php

namespace App\Controller\Editor;

use App\Attribute\ArgumentResolver\MapEntity;
use App\Controller\BaseController;
use App\Entity\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route(path: '/editor/elements', name: 'app_editor_elements_')]
class ElementController extends BaseController
{

}
