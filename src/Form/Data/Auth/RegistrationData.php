<?php

namespace App\Form\Data\Auth;

use App\Constants\Role;
use App\Contracts\EmailAwareInterface;
use App\Entity\Mandate;
use App\Entity\User;
use App\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

#[Constraint\EmailAvailable]
class RegistrationData implements EmailAwareInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public ?string $password = null;

    #[Assert\Length(min: 2, max: 255)]
    public ?string $mandate = null;

    #[Assert\Length(min: 2, max: 255)]
    #[Constraint\NoNumber]
    public ?string $firstname = null;

    #[Assert\Length(min: 2, max: 255)]
    #[Constraint\NoNumber]
    public ?string $lastname = null;

    #[Assert\IsTrue(message: 'Please accept our terms and conditions.')]
    public bool $termsAgreed = false;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toUser(): User
    {
        $user = new User(
            mandate: new Mandate($this->mandate ?: $this->email),
            email: $this->email,
            role: Role::NEW->value,
            locale: null,
            termsAgreed: $this->termsAgreed
        );

        $user->passwordPlain = $this->password;
        $user->setFirstname($this->firstname);
        $user->setLastname($this->lastname);

        return $user;
    }
}
