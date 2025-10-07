<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Exception\NotFoundException;
use App\Exception\SecurityException;
use App\Form\Type\Auth\ResetRequestType;
use App\Manager\AuthManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth/reset', name: 'app_auth_reset_')]
class ResetController extends BaseController
{
    #[Route(path: '/request', name: 'request')]
    public function request(Request $request, AuthManager $authManager): Response
    {
        $form = $this->createForm(ResetRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()->email;
            try {
                $authManager->resetPasswordRequest($email);
            } catch (SecurityException) {
                return $this->render('pages/auth/reset/request-result.html.twig', [
                    'form' => $form->createView(),
                    'error' => true,
                ]);
            } catch (NotFoundException) {}

            return $this->render('pages/auth/reset/request-result.html.twig', [
                'form' => $form->createView(),
                'email' => $email,
            ]);
        }

        return $this->render('pages/auth/reset/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/confirm', name: 'confirm')]
    public function confirm(Request $request): Response
    {
        $form = $this->createForm(ResetRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('pages/auth/reset/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
