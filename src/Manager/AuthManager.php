<?php

namespace App\Manager;

use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use LogicException;

final readonly class AuthManager
{
    const MAX_PASSWORD_RESET_REQUESTS = 5;
    const PASSWORD_RESET_REQUEST_TIME = 3600;

    public function __construct(
        private TokenRepository $tokenRepository,
    ) {}

    public function resetPasswordRequest(User $user): Token
    {
        $count = $this->tokenRepository->countUserToken($user, Token::PASSWORD_RESET_KEY);

        if ($count >= self::MAX_PASSWORD_RESET_REQUESTS) {
            throw new LogicException('Too many password reset requests');
        }

        $token = new Token($user, Token::PASSWORD_RESET_KEY, null, self::PASSWORD_RESET_REQUEST_TIME);
        $this->tokenRepository->persist($token);

        return $token;
    }
}
