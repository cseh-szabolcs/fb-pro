<?php

namespace App\Factory;

use App\Entity\Form;
use App\Entity\Form\FormVersion;
use App\Entity\User;
use App\Repository\FormRepository;

final readonly class FormFactory
{
    public function __construct(
        private FormRepository $formRepository
    ) {}

    public function create(User $owner, string $title): Form
    {
        $form = new Form($owner, $title, new FormVersion());
        $this->formRepository->persist($form);

        return $form;
    }
}
