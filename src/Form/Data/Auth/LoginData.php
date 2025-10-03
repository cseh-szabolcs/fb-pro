<?php

namespace App\Form\Data\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class LoginData
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $email;

    #[Assert\NotBlank]
    public ?string $password;

    public function __construct(?string $email = null, ?string $password = null)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
