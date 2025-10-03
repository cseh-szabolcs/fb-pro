<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Type\Auth\ResetRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth/reset', name: 'app_auth_reset_')]
class ResetController extends BaseController
{
    #[Route(path: '/request', name: 'request')]
    public function request(Request $request): Response
    {
        $form = $this->createForm(ResetRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('pages/auth/reset/index.html.twig', [
            'form' => $form->createView(),
            'action' => 'request',
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
