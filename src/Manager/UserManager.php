<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\AuthProvider;
use LogicException;

final readonly class UserManager
{
    public function __construct(
        private UserRepository $userRepository,
        private AuthProvider $authProvider,
    ) {}

    public function createAccount(User $user): void
    {
        if (empty($user->passwordPlain)) {
            throw new LogicException('User password cannot be empty.');
        }

        $this->authProvider->hashUserPassword($user);
        $this->userRepository->persist($user);
    }
}
