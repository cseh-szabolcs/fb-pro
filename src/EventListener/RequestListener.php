<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Constants\Lang;
use App\Security\AuthProvider;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener]
readonly class RequestListener
{
    public function __construct(
        private AuthProvider $auth,
    ) {}

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');

        if ($routeName === 'root') {
            $locale = $this->getLocale($request);
            $event->setResponse(new RedirectResponse("/$locale"));
        }

        if ($this->auth->isAuthenticated()) {
            $request->attributes->set('_app_auth', $this->auth->getMandate());
        }
    }

    private function getLocale(Request $request): string
    {
        if ($this->auth->isAuthenticated() && $locale = $this->auth->getUser()->getLocale()) {
            return $locale;
        }

        if ($lang = $request->getPreferredLanguage(Lang::getSupported())) {
            return $lang;
        }

        return Lang::getDefault();
    }
}
