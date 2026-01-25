<?php

namespace App\Factory\Editor;

use App\Contracts\Editor\FixtureFactoryInterface;
use App\Model\Editor\Fixture\FixtureElement;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class FormFixturesFactory implements FixtureFactoryInterface
{
    public function __construct(
        /** @var callable():FixtureFactoryInterface[] */
        #[AutowireIterator(tag: 'app.fixture.editor.form')]
        private iterable $factories,
    ) {}

    /**
     * @return array<FixtureElement>
     */
    public function create(): array
    {
        $elements = [];
        foreach ($this->factories as $factory) {
            foreach ($factory() as $element) {
                $elements[] = $element;
            }
        }

        return $elements;
    }
}
