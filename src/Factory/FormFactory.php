<?php

namespace App\Factory;

use App\Entity\Form;
use App\Entity\Form\FormVersion;
use App\Entity\User;
use App\Form\Data\Forms\CreateData;
use App\Repository\FormRepository;

final readonly class FormFactory
{
    public function __construct(
        private FormRepository $formRepository
    ) {}

    public function create(User $owner, CreateData $data): Form
    {
        $form = new Form($owner, $data->title, new FormVersion(), $data->description);
        $this->formRepository->persist($form);

        return $form;
    }
}
