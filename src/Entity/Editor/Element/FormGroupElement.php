<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\FormGroupData;
use App\Model\Editor\Data\ViewData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class FormGroupElement extends ViewElement
{
    const TYPE = FormGroupData::TYPE;

    public function __construct(FormGroupData $data, ViewElement $parent)
    {
        parent::__construct($data, $parent);
    }

    /** @param ViewElement $child */
    public function addChild(BaseElement $child): self
    {
        assert($child instanceof ViewElement);
        parent::addChild($child);

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
