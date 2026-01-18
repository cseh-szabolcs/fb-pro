<?php

namespace App\Entity\Form;

use App\Contracts\Entity\Editor\DocumentAwareInterface;
use App\Contracts\Entity\UuidAwareInterface;
use App\Entity\Editor\Element\DocumentElement;
use App\Entity\Form;
use App\Repository\Form\FormVersionRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\UpdatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FormVersionRepository::class)]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\HasLifecycleCallbacks]
class FormVersion implements UuidAwareInterface, DocumentAwareInterface
{
    use UuidAwareTrait;
    use UpdatedTrait;
    use CreatedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Form $form;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?DocumentElement $document;

    public function __construct(Form $form, DocumentElement $document)
    {
        $this->form = $form;
        $this->document = $document;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['editor'])]
    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    #[Groups(['editor'])]
    public function getDocument(): DocumentElement
    {
        return $this->document;
    }
}
