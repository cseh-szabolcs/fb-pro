<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Type\Auth\ResetType;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'app_auth_')]
class ResetController extends BaseController
{
    #[Route(path: '/reset', name: 'reset')]
    public function __invoke()
    {
        $form = $this->createForm(ResetType::class);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('pages/auth/reset/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
