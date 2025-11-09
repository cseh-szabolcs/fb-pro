<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\DocumentData;
use App\Repository\Editor\ElementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[Groups(['editor'])]
#[ORM\Entity(repositoryClass: ElementRepository::class)]
class DocumentElement extends BaseElement
{
    const TYPE = 'document';

    public function __construct(DocumentData $data)
    {
        parent::__construct($data);
    }
}
