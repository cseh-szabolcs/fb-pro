<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Security\AuthProvider;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    const ROUTE_NAME = 'app_home';

    #[Route('/', name: self::ROUTE_NAME)]
    public function __invoke(AuthProvider $auth): Response
    {
        if ($auth->isAuthenticated()) {
            return $this->home();
        }

        return $this->render('pages/home/intro.html.twig');
    }

    private function home(): Response
    {
        return $this->render('pages/home/intro.html.twig');
    }
}
