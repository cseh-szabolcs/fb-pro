<?php

namespace App\Entity\Editor\Element;

use App\Contracts\Entity\Editor\InputElementInterface;
use App\Model\Editor\ElementData\InputData;
use App\Repository\Editor\ElementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class InputElement extends BaseElement implements InputElementInterface
{
    const TYPE = InputData::TYPE;

    public function __construct(InputData $data, ViewElement $parent)
    {
        parent::__construct($data, $parent);
    }

    /** @param ViewElement $child */
    public function addChild(BaseElement $child): self
    {
        $this->deny('Input element cannot have children');
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
