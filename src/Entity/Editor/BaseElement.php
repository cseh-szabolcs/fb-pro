<?php

namespace App\Entity\Editor;

use App\Doctrine\EntityListener\ElementListener;
use App\Doctrine\Type\JsonDocumentType;
use App\Model\Editor\BaseData;
use App\Repository\Editor\ElementRepository;
use App\Traits\Entity\UuidAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
#[ORM\Table(name: 'editor_elements')]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(BaseElement::TYPES)]
#[ORM\EntityListeners(value: [ElementListener::class])]
abstract class BaseElement
{
    use UuidAwareTrait;

    const TYPES = [

    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?int $id = null;

    #[ORM\Column(type: JsonDocumentType::NAME)]
    protected ?BaseData $data;

    #[ORM\ManyToOne(targetEntity: BaseElement::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    protected ?BaseElement $parent = null;

    /** @var Collection<int, BaseElement> */
    #[ORM\OneToMany(targetEntity: BaseElement::class, mappedBy: 'parent', cascade: ['persist', 'remove'], orphanRemoval: true)]
    protected Collection $children;

    public function __construct(BaseData $data, ?BaseElement $parent = null)
    {
        $this->uuid = Uuid::v4();
        $this->data = $data;
        $this->parent = $parent;
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParent(): BaseElement
    {
        return $this->parent;
    }

    public function addChild(BaseElement $child): self
    {
        $this->children->add($child);
        assert($child->getParent() === $this);;

        return $this;
    }

    /** @return Collection<int, BaseElement> */
    public function getChildren(): Collection
    {
        return $this->children;
    }
}
