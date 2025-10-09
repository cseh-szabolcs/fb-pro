<?php

namespace App\Form\Data\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class ResetData
{
    #[Assert\NotBlank]
    public ?string $password;
}
