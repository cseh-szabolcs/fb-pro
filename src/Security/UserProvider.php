<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class UserProvider implements UserProviderInterface
{
    public const USER_REFRESH_TIME = 60; // seconds

    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if ($user = $this->userRepository->findOneBy(['email' => $identifier])) {
            return $user;
        }

        throw new UserNotFoundException();
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user = $this->userRepository->findOneBy(['email' => $user->getUserIdentifier()])) {
            throw new UserNotFoundException();
        }

        if ($this->hasLastAccessExpired($user)) {
            $user->refreshLastAccess();
            $this->userRepository->flush();
        }

        return $user;
    }

    private function hasLastAccessExpired(User $user): bool
    {
        return $user->getLastAccess()->getTimestamp()
            < (new DateTimeImmutable())->getTimestamp() - self::USER_REFRESH_TIME;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}
