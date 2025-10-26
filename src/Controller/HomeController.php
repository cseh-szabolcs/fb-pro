<?php

namespace App\Controller;

use App\Attribute\Security\Grant;
use App\Constants\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'intro')]
    #[Grant(role: Role::GUEST, redirect: Grant::ROUTE_HOME)]
    public function intro(): Response
    {
        return $this->render('pages/home/intro.html.twig');
    }

    #[Route('/home', name: 'home', alias: ['app_index', 'root'])]
    #[Grant(role: Role::AUTH, redirect: Grant::ROUTE_GUEST)]
    public function index(): Response
    {
        return $this->render('pages/home/index.html.twig');
    }
}
