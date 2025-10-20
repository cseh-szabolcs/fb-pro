<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constants\Role;
use App\Security\Attribute\SoftGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'intro')]
    #[SoftGranted(role: Role::GUEST, redirect: SoftGranted::ROUTE_HOME)]
    public function intro(): Response
    {
        return $this->render('pages/home/intro.html.twig');
    }

    #[Route('/home', name: 'home', alias: ['app_index', 'root'])]
    #[SoftGranted(role: Role::AUTH, redirect: SoftGranted::ROUTE_GUEST)]
    public function index(): Response
    {
        return $this->render('pages/home/index.html.twig');
    }
}
