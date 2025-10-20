<?php

namespace App\Controller\Auth;

use App\Constants\Role;
use App\Controller\BaseController;
use App\Form\Data\Auth\LoginData;
use App\Form\Type\Auth\LoginType;
use App\Security\Attribute\SoftGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'app_auth_')]
class LoginController extends BaseController
{
    #[Route(path: '/login', name: 'login')]
    #[SoftGranted(role: Role::GUEST, redirect: SoftGranted::ROUTE_HOME)]
    public function login(): Response {
        $utils = $this->getAuth()->utils;
        $form = $this->createForm(LoginType::class, new LoginData($utils->getLastUsername()));
        $error = $utils->getLastAuthenticationError();

        return $this->render('pages/auth/login/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new ('Handled by symfony.');
    }
}
