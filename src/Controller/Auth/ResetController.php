<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Entity\Token;
use App\Exception\NotFoundException;
use App\Exception\SecurityException;
use App\Form\Type\Auth\ResetType;
use App\Form\Type\Auth\ResetRequestType;
use App\Manager\AuthManager;
use App\Security\Attribute\GuestGranted;
use App\Security\TokenVerifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth/reset', name: 'app_auth_reset_')]
class ResetController extends BaseController
{
    public function __construct(
        private readonly AuthManager $authManager,
    ) {}

    #[Route(name: 'request')]
    #[GuestGranted]
    public function request(Request $request): Response
    {
        if ($email = $this->isPRGResponse()) {

            return $this->render('pages/auth/reset/success.html.twig', [
                'result' => 'requested',
                'email' => $email,
            ]);
        }

        $form = $this->createForm(ResetRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()->email;
            try {
                $this->authManager->resetPasswordRequest($email);
            } catch (SecurityException) {

                return $this->render('pages/auth/reset/exceeded.html.twig');
            } catch (NotFoundException) {}

           return $this->createPRGResponse($email);
        }

        return $this->render('pages/auth/reset/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{token}', name: 'confirm')]
    public function confirm(Request $request, TokenVerifier $tokenVerifier, ?Token $token = null): Response
    {
        if ($this->isPRGResponse()) {

            return $this->render('pages/auth/reset/success.html.twig', [
                'result' => 'password_changed',
            ]);
        }

        try {
            $tokenVerifier->verify($token, true);
        } catch (SecurityException) {
            $this->addFlash('auth_reset_invalid_token', 'Invalid token.');

            return $this->redirectToRoute('app_auth_reset_request');
        }

        $form = $this->createForm(ResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authManager->resetPassword($token, $form->getData()->password);

            return $this->createPRGResponse();
        }

        return $this->render('pages/auth/reset/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
