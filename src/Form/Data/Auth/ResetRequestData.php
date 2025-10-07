<?php

namespace App\Form\Data\Auth;

use App\Contracts\EmailAwareInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ResetRequestData implements EmailAwareInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $email;

    public function getEmail(): string
    {
        return $this->email ?? '';
    }
}
