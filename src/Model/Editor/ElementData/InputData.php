<?php

namespace App\Model\Editor\ElementData;

use App\Constants\Editor\InputType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class InputData extends BaseData
{
    const TYPE = 'input';

    #[Groups(['editor'])]
    #[Assert\NotBlank]
    public ?string $label = null;

    #[Groups(['editor'])]
    #[Assert\NotBlank]
    public ?InputType $inputType = null;

    #[Groups(['editor'])]
    #[Assert\NotBlank]
    public ?string $name = null;

    #[Groups(['editor'])]
    public ?string $value = null;

    #[Groups(['editor'])]
    #[Assert\NotBlank]
    public ?string $id = null;

    #[Groups(['editor'])]
    public ?string $placeholder = null;

    #[Groups(['editor'])]
    public bool $required = false;

    public function __construct(InputType|string $inputType, array $data = [])
    {
        parent::__construct($data);

        $this->inputType = is_string($inputType)
            ? InputType::from($inputType)
            : $inputType;
    }
}
