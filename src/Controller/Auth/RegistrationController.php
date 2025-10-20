<?php

namespace App\Controller\Auth;

use App\Constants\Role;
use App\Controller\BaseController;
use App\Entity\Token;
use App\Exception\SecurityException;
use App\Form\Data\Auth\RegistrationData;
use App\Form\Type\Auth\RegistrationType;
use App\Manager\UserManager;
use App\Security\Attribute\Grant;
use App\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth/registration', name: 'app_auth_registration_')]
class RegistrationController extends BaseController
{
    #[Route(name: 'index')]
    #[Grant(role: Role::GUEST, redirect: Grant::ROUTE_HOME)]
    public function registration(Request $request, UserAuthenticator $authenticator, UserManager $userManager): Response
    {
        $form = $this->createForm(RegistrationType::class, new RegistrationData());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RegistrationData $data */
            $data = $form->getData();
            $user = $data->toUser();

            $userManager->createAccount($user);
            $this->addFlash('success', 'Registration successful. You can now log in.');

            if ($response = $authenticator->login($user)) {
                return $response;
            }

            return $this->redirectToRoute('app_auth_login');
        }

        return $this->render('pages/auth/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{token}', name: 'confirm')]
    public function confirm(UserManager $userManager, ?Token $token = null): Response
    {
        try {
            $user = $userManager->confirmAccount($token);
            return $this->render('pages/auth/registration/confirm.html.twig', [
                'user' => $user,
            ]);

        } catch (SecurityException) {
            return $this->render('pages/auth/registration/confirm.html.twig', [
                'error' => true,
            ]);
        }
    }
}
