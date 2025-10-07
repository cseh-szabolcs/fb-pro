<?php

namespace App\Manager;

use App\Entity\Token;
use App\Event\Auth\PasswordResetEvent;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Traits\Service\EventDispatcherTrait;
use LogicException;

final readonly class AuthManager
{
    use EventDispatcherTrait;

    const MAX_PASSWORD_RESET_REQUESTS = 5;
    const PASSWORD_RESET_REQUEST_TIME = 3600;

    public function __construct(
        private UserRepository $userRepository,
        private TokenRepository $tokenRepository,
    ) {}

    public function resetPasswordRequest(string $email): Token
    {
        $user = $this->userRepository->findOneByEmail($email);
        $count = $this->tokenRepository->countUserToken($user, Token::TYPE_PASSWORD_RESET);

        if ($count >= self::MAX_PASSWORD_RESET_REQUESTS) {
            throw new LogicException('Too many password reset requests');
        }

        $token = new Token($user, Token::TYPE_PASSWORD_RESET, null, self::PASSWORD_RESET_REQUEST_TIME);
        $this->tokenRepository->persist($token);
        $this->dispatchEvent(new PasswordResetEvent($token));

        return $token;
    }
}
