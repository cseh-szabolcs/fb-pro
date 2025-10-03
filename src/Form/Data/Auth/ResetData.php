<?php

namespace App\Form\Data\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class ResetData
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $email;

    #[Assert\NotBlank]
    public ?string $password;
}
