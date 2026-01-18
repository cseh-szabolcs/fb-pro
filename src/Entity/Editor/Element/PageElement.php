<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\PageData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class PageElement extends BaseElement
{
    const TYPE = PageData::TYPE;

    public function __construct(PageData $data, DocumentElement $parent)
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

    /** @return Collection<int, ViewElement> */
    public function getChildren(): Collection
    {
        return parent::getChildren();
    }
}
