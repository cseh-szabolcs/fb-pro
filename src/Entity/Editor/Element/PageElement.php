<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\PageData;
use App\Repository\Editor\ElementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class PageElement extends BaseElement
{
    public function __construct(PageData $data, DocumentElement $parent)
    {
        parent::__construct($data, $parent);
    }
}
