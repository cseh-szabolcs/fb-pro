<?php

namespace App\Manager;

use App\Constants\Role;
use App\Entity\Token;
use App\Entity\User;
use App\Event\Auth\RegistrationEvent;
use App\Repository\UserRepository;
use App\Security\AuthProvider;
use App\Security\TokenVerifier;
use App\Traits\Service\EventDispatcherTrait;
use LogicException;

final readonly class UserManager
{
    use EventDispatcherTrait;

    public function __construct(
        private UserRepository $userRepository,
        private AuthProvider $authProvider,
        private TokenVerifier $tokenVerifier,
    ) {}

    public function createAccount(User $user): void
    {
        if (empty($user->passwordPlain)) {
            throw new LogicException('User password cannot be empty.');
        }

        $this->authProvider->hashUserPassword($user);
        $this->userRepository->persist($user);
        $token = new Token($user, Token::TYPE_REGISTRATION);
        $this->userRepository->persist($token);
        $this->dispatchEvent(new RegistrationEvent($user, $token));
    }

    public function confirmAccount(?Token $token = null): User
    {
        $user = $this->tokenVerifier->verify($token);
        $user->setRole($user->getMandate()->getOwner()->getId() === $user->getId()
            ? Role::MANDANT
            : Role::USER
        );
        $user->confirm();

        return $user;
    }
}
