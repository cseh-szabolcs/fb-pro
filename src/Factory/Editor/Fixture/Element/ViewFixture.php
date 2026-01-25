<?php

namespace App\Factory\Editor\Fixture\Element;

use App\Model\Editor\ElementData\ViewData;
use App\Model\Editor\Fixture\FixtureData;
use App\Model\Editor\Fixture\FixtureElement;
use Generator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.fixture.editor.form')]
class ViewFixture extends AbstractElementFixture
{
    public function __invoke(): Generator
    {
        yield new FixtureElement(
            data: new ViewData(),
            fixtureData: new FixtureData(
                name: 'View',
                description: 'View-Element',
                tags: ['view'],
            ),
        );
    }
}
