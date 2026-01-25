<?php

namespace App\Manager;

use App\Entity\Form;
use App\Event\Form\FormCreatedEvent;
use App\Event\Form\FormDeletedEvent;
use App\Factory\Editor\FormFactory;
use App\Form\Data\Forms\CreateData;
use App\Repository\FormRepository;
use App\Security\AuthProvider;
use App\Traits\Service\EventDispatcherTrait;

final readonly class FormManager
{
    use EventDispatcherTrait;

    public function __construct(
        private FormFactory $formFactory,
        private AuthProvider $authProvider,
        private FormRepository $formRepository,
    ) {}

    public function create(CreateData $data): Form
    {
        $form = $this->formFactory->create($this->authProvider->getUser(), $data);
        $this->formRepository->persist($form);
        $this->dispatchEvent(new FormCreatedEvent($form));

        return $form;
    }

    public function remove(Form $form): void
    {
        $this->formRepository->remove($form);
        $this->dispatchEvent(new FormDeletedEvent($form));
    }
}
