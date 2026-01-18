<?php

namespace App\Factory;

use App\Constants\Editor\InputType;
use App\Entity\Editor\Element\DocumentElement;
use App\Entity\Editor\Element\InputElement;
use App\Entity\Editor\Element\PageElement;
use App\Entity\Editor\Element\ViewElement;
use App\Entity\Form;
use App\Entity\Form\FormVersion;
use App\Entity\User;
use App\Form\Data\Forms\CreateData;
use App\Model\Editor\ElementData\DocumentData;
use App\Model\Editor\ElementData\InputData;
use App\Model\Editor\ElementData\PageData;
use App\Model\Editor\ElementData\ViewData;

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
        $view1 = $this->createView($page);
        $document->addChild($page);

        $this->createInput(InputType::Text->value, $view1, [
            'name' => 'Vorname',
            'placeholder' => 'Vorname',
        ]);

        $this->createInput(InputType::Text->value, $view1, [
            'name' => 'Nachname',
            'placeholder' => 'Nachname',
            'required' => true,
        ]);

        return $document;
    }


    private function createView(ViewElement|PageElement $parent): ViewElement
    {
        $view = new ViewElement(new ViewData(), $parent);
        $parent->addChild($view);

        return $view;
    }

    private function createInput(string $type, ViewElement $view, array $data): void
    {
        $input = new InputElement(new InputData(InputType::from($type), $data), $view);
        $view->addChild($input);
    }
}
