<?php

namespace App\Entity\Editor\Element;

use App\Model\Editor\ElementData\DocumentData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[Groups(['editor'])]
#[ORM\Entity(repositoryClass: ElementRepository::class)]
class DocumentElement extends BaseElement
{
    const TYPE = DocumentData::TYPE;

    public function __construct(DocumentData $data)
    {
        parent::__construct($data);
    }

    /** @param PageElement $child */
    public function addChild(BaseElement $child): self
    {
        assert($child instanceof PageElement);
        parent::addChild($child);

        return $this;
    }

    /** @return Collection<int, PageElement> */
    public function getChildren(): Collection
    {
        return parent::getChildren();
    }
}
