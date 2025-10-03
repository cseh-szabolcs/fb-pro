<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Data\Auth\RegistrationData;
use App\Form\Type\Auth\RegistrationType;
use App\Manager\UserManager;
use App\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'app_auth_')]
class RegistrationController extends BaseController
{
    #[Route(path: '/registration', name: 'registration')]
    public function __invoke(Request $request, UserAuthenticator $authenticator, UserManager $userManager): Response
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
}
