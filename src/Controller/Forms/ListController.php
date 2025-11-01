<?php

namespace App\Controller\Forms;

use App\Attribute\Request\XhrRequest;
use App\Controller\BaseController;
use App\Form\Data\Forms\CreateData;
use App\Form\Type\Forms\CreateType;
use App\Manager\FormManager;
use App\Repository\FormRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/forms', name: 'app_forms_')]
class ListController extends BaseController
{
    #[Route(name: 'index')]
    public function login(): Response
    {
        $form = $this->createForm(CreateType::class, new CreateData());

        return $this->render('pages/forms/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/fetch', name: 'fetch')]
    public function fetch(FormRepository $formRepository): JsonResponse
    {
        $list = $formRepository->getList($this->getAuth()->getUser());

        return $this->toJson($list);
    }

    #[XhrRequest]
    #[Route('/create', name: 'create', methods: 'POST')]
    public function create(Request $request, FormManager $formManager): JsonResponse
    {
        $form = $this->createForm(CreateType::class, new CreateData());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formManager->create($form->getData());

            return $this->toJson(true);
        }

        return $this->toJson($form->getErrors(true));
    }
}
