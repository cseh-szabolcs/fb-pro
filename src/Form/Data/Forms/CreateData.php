<?php

namespace App\Form\Data\Forms;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateData
{
    #[Assert\Blank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $title = null;
}
