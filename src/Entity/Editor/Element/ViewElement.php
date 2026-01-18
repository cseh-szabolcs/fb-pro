<?php

namespace App\Entity\Editor\Element;

use App\Contracts\Entity\Editor\ViewElementInterface;
use App\Model\Editor\ElementData\ViewData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class ViewElement extends BaseElement implements ViewElementInterface
{
    const TYPE = ViewData::TYPE;

    public function __construct(ViewData $data, PageElement|ViewElement $parent)
    {
        parent::__construct($data, $parent);
    }

    /** @param ViewElement $child */
    public function addChild(BaseElement $child): self
    {
        assert($child instanceof ViewElementInterface);
        parent::addChild($child);

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
