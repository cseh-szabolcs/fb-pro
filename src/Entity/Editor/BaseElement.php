<?php

namespace App\Entity\Editor;

use App\Constants\Entity\ElementScope;
use App\Contracts\Entity\EditorScopeInterface;
use App\Doctrine\EntityListener\ElementListener;
use App\Doctrine\Type\JsonDocumentType;
use App\Model\Editor\Data\BaseData;
use App\Traits\Entity\UuidAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'editor_elements')]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\Index(name: 'scope_idx', columns: ['scope_id'])]
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

    #[ORM\Column(type: Types::STRING, nullable: false, enumType: ElementScope::class)]
    protected ?ElementScope $scope = null;

    #[ORM\Column(nullable: false)]
    protected ?string $scopeId;

    #[ORM\Column(type: JsonDocumentType::NAME)]
    protected ?BaseData $data;

    #[ORM\ManyToOne(targetEntity: BaseElement::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    protected ?BaseElement $parent = null;

    /** @var ArrayCollection<int, BaseElement> */
    #[ORM\OneToMany(targetEntity: BaseElement::class, mappedBy: 'parent', cascade: ['persist', 'remove'], orphanRemoval: true)]
    protected ArrayCollection $children;

    public function __construct(EditorScopeInterface $scope, BaseData $data, ?BaseElement $parent = null)
    {
        $this->uuid = Uuid::v4();
        $this->scope = $scope->getName();
        $this->scopeId = $scope->getId();
        $this->data = $data;
        $this->parent = $parent;
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScope(): ElementScope
    {
        return $this->scope;
    }

    public function getScopeId(): string
    {
        return $this->scopeId;
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

    /** @return  ArrayCollection<int, BaseElement> */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }
}
