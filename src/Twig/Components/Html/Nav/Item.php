<?php

namespace App\Twig\Components\Html\Nav;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
final class Item
{
    public string $label;
    public string $route;
    public ?array $params = null;

    public function __construct(
        private readonly RouterInterface $router,
        private readonly RequestStack $requestStack,
    ) {}

    #[ExposeInTemplate]
    public function getHref(): string
    {
        return $this->router->generate($this->route, $this->params ?? []);
    }

    #[ExposeInTemplate]
    public function getActive(): bool
    {
        return $this->requestStack->getCurrentRequest()->get('_route') === $this->route;
    }
}
