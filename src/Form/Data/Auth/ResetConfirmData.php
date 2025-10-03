<?php

namespace App\Form\Data\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class ResetConfirmData
{
    #[Assert\NotBlank]
    public ?string $password;

    public ?string $token;
}
