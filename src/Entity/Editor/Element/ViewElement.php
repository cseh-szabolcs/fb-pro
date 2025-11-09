<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\ViewData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class ViewElement extends BaseElement
{
    const TYPE = ViewData::TYPE;

    public function __construct(ViewData $data, PageElement|ViewElement $parent)
    {
        parent::__construct($data, $parent);
    }

    /** @param ViewElement $child */
    public function addChild(BaseElement $child): self
    {
        assert($child instanceof ViewElement);

        return parent::addChild($child);
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
