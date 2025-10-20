<?php

namespace App\Security;

use App\Constants\Role;
use App\Entity\Mandate;
use App\Entity\User;
use LogicException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final readonly class AuthProvider
{
    public function __construct(
        private Security $security,
        public AuthenticationUtils $utils,
        public UserPasswordHasherInterface $passwordHasher,
        private TokenStorageInterface $tokenStorage,
        private RoleHierarchyInterface $roleHierarchy,

    ) {}

    public function getUser(): User
    {
        /** @var User $user */
        if ($user = $this->tokenStorage->getToken()?->getUser()) {
            return $user;
        }

        $this->notAuthenticatedException();
    }

    public function getMandate(): Mandate
    {
        if ($mandate = $this->getUser()->getMandate()) {
            return $mandate;
        }

        $this->notAuthenticatedException();
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->tokenStorage->getToken();
    }

    public function isGranted(mixed $attributes, mixed $subject = null): bool
    {
        return $this->security->isGranted($attributes, $subject);
    }

    public function getRole(): Role
    {
        if ($role = $this->getUser()->getRole()) {
            return $role;
        }

        return Role::GUEST;
    }

    public function getToken(): TokenInterface
    {
        return $this->tokenStorage->getToken();
    }

    public function hasRole(Role $role, ?User $user = null, bool $strict = false): bool
    {
        if ($role === Role::GUEST) {
            return !$this->isAuthenticated();
        }

        if (!$user && !$this->isAuthenticated()) {
            return false;
        }

        $user ??= $this->getUser();

        if ($strict) {
            return $user->getRole() === $role;
        }

        $roles = $this->roleHierarchy->getReachableRoleNames([$user->getRole()->value]);

        return in_array($role->value, $roles, true);
    }

    public function hashUserPassword(User $user): void
    {
        if ($password = $user->passwordPlain) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $password),
            );
            $user->eraseCredentials();
        }
    }

    private function notAuthenticatedException()
    {
        throw new LogicException('User is not authenticated.');
    }
}
