<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Entity\Mandate;
use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends BaseController
{
    #[Route(path: '/registration', name: 'app_auth_registration')]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $mandate = new Mandate($data['mandateName']);
            $user = new User(
                $mandate,
                $data['email'],
            );

            $user->passwordPlain = $data['plainPassword'];

            if (!empty($data['firstname'])) {
                $user->setFirstname($data['firstname']);
            }
            if (!empty($data['lastname'])) {
                $user->setLastname($data['lastname']);
            }
            if (!empty($data['locale'])) {
                $user->setLocale($data['locale']);
            }

            $this->getAuth()->hashUserPassword($user);
            $this->saveEntity($user);

            $this->addFlash('success', 'Registration successful. You can now log in.');

            return $this->redirectToRoute('app_auth_login');
        }

        return $this->render('pages/auth/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

