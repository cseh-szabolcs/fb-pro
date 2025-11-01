<?php

namespace App\Manager;

use App\Entity\Form;
use App\Event\Form\FormCreatedEvent;
use App\Factory\FormFactory;
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
    ) {}

    public function create(CreateData $data): Form
    {
        $form = $this->formFactory->create($this->authProvider->getUser(), $data->title);
        $this->dispatchEvent(new FormCreatedEvent($form));

        return $form;
    }
}
