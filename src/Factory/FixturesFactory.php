<?php

namespace App\Factory;

use App\Factory\Element\AbstractElementFactory;
use App\Model\Editor\Fixture\ElementFixture;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class FixturesFactory
{
    public function __construct(
        /** @var callable():AbstractElementFactory[] */
        #[AutowireIterator(tag: 'app.factory.element')]
        private iterable $factories,
    ) {}

    /**
     * @return array<ElementFixture>
     */
    public function create(): array
    {
        $elements = [];
        foreach ($this->factories as $factory) {
            $elements[] = $factory();
        }

        return $elements;
    }
}
