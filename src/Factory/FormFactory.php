<?php

namespace App\Factory;

use App\Entity\Editor\Element\DocumentElement;
use App\Entity\Form;
use App\Entity\Form\FormVersion;
use App\Entity\User;
use App\Form\Data\Forms\CreateData;
use App\Model\Editor\Data\DocumentData;
use App\Repository\FormRepository;

final readonly class FormFactory
{
    public function __construct(
        private FormRepository $formRepository
    ) {}

    public function create(User $owner, CreateData $data): Form
    {
        $form = new Form($owner, $data->title, $data->description);

        $draftVersion = new FormVersion($form, $this->createDocument());
        $form->setDraftVersion($draftVersion);
        $this->formRepository->persist($form);

        return $form;
    }

    private function createDocument(): DocumentElement
    {
        $document = new DocumentElement(new DocumentData());

        return $document;
    }
}
