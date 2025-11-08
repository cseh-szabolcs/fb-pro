<?php

namespace App\Entity\Editor\Element;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\Data\DocumentData;
use App\Repository\Editor\ElementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
final class DocumentElement extends BaseElement
{
    const TYPE = 'document';

    public function __construct(DocumentData $data)
    {
        parent::__construct($data);
    }
}
