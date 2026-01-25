<?php

namespace App\Factory\Editor;

use App\Contracts\Editor\FixtureFactoryInterface;
use App\Factory\Fixture\Element\AbstractElementFixture;
use App\Model\Editor\Fixture\ElementFixture;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class FormFixturesFactory implements FixtureFactoryInterface
{
    public function __construct(
        /** @var callable():AbstractElementFixture[] */
        #[AutowireIterator(tag: 'app.fixture.editor.form')]
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
