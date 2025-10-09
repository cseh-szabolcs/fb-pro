<?php

namespace App\Manager;

use App\Entity\Token;
use App\Event\Auth\PasswordResetEvent;
use App\Event\Auth\PasswordResetRequestEvent;
use App\Exception\SecurityException;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Security\AuthProvider;
use App\Security\TokenVerifier;
use App\Traits\Service\EventDispatcherTrait;

final readonly class AuthManager
{
    use EventDispatcherTrait;

    const MAX_PASSWORD_RESET_REQUESTS = 5;
    const PASSWORD_RESET_REQUEST_TIME = 3600;

    public function __construct(
        private UserRepository $userRepository,
        private TokenRepository $tokenRepository,
        private AuthProvider $authProvider,
        private TokenVerifier $tokenVerifier,
    ) {}

    public function resetPasswordRequest(string $email): Token
    {
        $user = $this->userRepository->findOneByEmail($email);
        $count = $this->tokenRepository->countUserToken($user, Token::TYPE_PASSWORD_RESET);

        if ($count >= self::MAX_PASSWORD_RESET_REQUESTS) {
            throw new SecurityException('Too many password reset requests');
        }

        $token = new Token($user, Token::TYPE_PASSWORD_RESET, null, self::PASSWORD_RESET_REQUEST_TIME);
        $this->tokenRepository->persist($token);
        $this->dispatchEvent(new PasswordResetRequestEvent($token, $user));

        return $token;
    }

    public function resetPassword(Token $token, string $newPasswort): void
    {
        $user = $this->tokenVerifier->verify($token);
        $user->passwordPlain = $newPasswort;
        $this->authProvider->hashUserPassword($user);
        $this->userRepository->flush();
        $this->dispatchEvent(new PasswordResetEvent($user));
    }
}
