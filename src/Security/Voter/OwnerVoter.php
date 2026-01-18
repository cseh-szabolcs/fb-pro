<?php

namespace App\Security\Voter;

use App\Contracts\OwnerAwareInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class OwnerVoter extends Voter
{
    public const ACCESS = 'OWNER_ACCESS';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute == self::ACCESS && $subject instanceof OwnerAwareInterface;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, Vote|null $vote = null): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($owner = $subject->getOwner()) {
            return $owner->getId() === $user->getId();
        }

        return false;
    }
}
