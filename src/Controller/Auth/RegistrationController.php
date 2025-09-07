<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends BaseController
{
    #[Route(path: '/registration', name: 'app_registration')]
    public function __invoke()
    {
        return $this->render('auth/registration/index.html.twig');
    }
}

