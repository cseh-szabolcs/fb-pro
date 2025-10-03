<?php

declare(strict_types=1);

namespace App\Security;

use App\App;
use App\Entity\User;
use App\Model\Auth\Credentials;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public function __construct(
        private readonly UserProvider $userProvider,
        private readonly App $app,
        private readonly UserAuthenticatorInterface $userAuthenticator,
    ) {}

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST')
            && $this->getLoginUrl($request) === $this->app->getCurrentPath();
    }

    public function authenticate(Request $request): Passport
    {
        $badges = [new RememberMeBadge()];

        $credentials = $this->createCredentials($badges, $request);
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $credentials->identifier);

        return new Passport(
            new UserBadge($credentials->identifier, $this->userProvider->loadUserByIdentifier(...)),
            new PasswordCredentials($credentials->password),
            $badges,
        );
    }

    public function authenticateUser(User $user): ?Response
    {
        return $this->userAuthenticator->authenticateUser($user, $this, $this->app->getMainRequest());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse('/');
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->app->urlGenerator->generate('app_auth_login');
    }

    private function createCredentials(array &$badges, Request $request): Credentials
    {
        $payload = $request->getPayload();
        array_unshift($badges, new CsrfTokenBadge(
            'authenticate',
            $payload->getString('_csrf_token'),
        ));

        return new Credentials(
            $payload->getString('email'),
            $payload->getString('password'),
        );
    }
}
