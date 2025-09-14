<?php

declare(strict_types=1);

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    const ROUTE_NAME = 'app_home';

    #[Route('/', name: self::ROUTE_NAME)]
    public function __invoke(): Response
    {
        return $this->render('pages/home/index.html.twig');
    }
}
