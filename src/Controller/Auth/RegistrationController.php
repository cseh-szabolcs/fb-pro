<?php

namespace App\Controller\Auth;

use App\App;
use App\Controller\BaseController;
use App\Form\Data\RegistrationData;
use App\Form\Type\RegistrationType;
use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends BaseController
{
    #[Route(path: '/registration', name: 'app_auth_registration')]
    public function __invoke(App $app, UserManager $userManager): Response
    {
        $form = $this->createForm(RegistrationType::class, new RegistrationData());
        $form->handleRequest($app->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RegistrationData $data */
            $data = $form->getData();
            $user = $data->toUser();

            $userManager->createAccount($user);
            $this->addFlash('success', 'Registration successful. You can now log in.');

            if ($response = $app->authenticator->login($user)) {
                return $response;
            }

            return $this->redirectToRoute('app_auth_login');
        }

        return $this->render('pages/auth/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
