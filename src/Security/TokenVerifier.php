<?php

namespace App\Security;

use App\Entity\Token;
use App\Entity\User;
use App\Exception\SecurityException;
use App\Repository\TokenRepository;

final readonly class TokenVerifier
{
    public function __construct(
        private TokenRepository $tokenRepository,
    ) {}

    public function verify(?Token $token = null, bool $keepToken = false): User
    {
        if (!$token) {
            throw new SecurityException('Token does not exist');
        }

        if ($token->isExpired()) {
            throw new SecurityException('Token expired');
        }

        $user = $token->getOwner();
        if ($keepToken) {
            $token->setTtl(null);
        } else {
            $this->tokenRepository->remove($token);
            $this->tokenRepository->flush();
        }

        return $user;
    }
}
