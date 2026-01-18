<?php

namespace App\Factory;

use App\Entity\Editor\Element\DocumentElement;
use App\Entity\Editor\Element\PageElement;
use App\Entity\Editor\Element\ViewElement;
use App\Entity\Form;
use App\Entity\Form\FormVersion;
use App\Entity\User;
use App\Form\Data\Forms\CreateData;
use App\Model\Editor\Data\DocumentData;
use App\Model\Editor\Data\PageData;
use App\Model\Editor\Data\ViewData;

final readonly class FormFactory
{

    public function create(User $owner, CreateData $data): Form
    {
        $form = new Form($owner, $data->title, $data->description);

        $draftVersion = new FormVersion($form, $this->createDocument());
        $form->setDraftVersion($draftVersion);

        return $form;
    }

    private function createDocument(): DocumentElement
    {
        $document = new DocumentElement(new DocumentData([
            'backgroundColor' => '#ffffff',
            'textColor' => '#000000',
        ]));

        $page = new PageElement(new PageData(), $document);
        $page->addChild(new ViewElement(new ViewData(), $page));

        $document->addChild($page);

        return $document;
    }
}
