<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'app_auth_')]
class LoginController extends BaseController
{
    #[Route(path: '/login', name: 'login')]
    public function login(): Response {
        $utils = $this->getAuth()->utils;
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        $lastPassword = null;

        return $this->render('pages/auth/login/index.html.twig', [
            'last_username' => $lastUsername,
            'last_password' => $lastPassword,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new ('Handled by symfony.');
    }
}
