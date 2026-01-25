<?php

namespace App\Factory\Editor\Fixture\Element;

use App\Model\Editor\ElementData\ViewData;
use App\Model\Editor\Fixture\ElementFixture;
use Generator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.fixture.editor.form')]
class ViewFixture extends AbstractElementFixture
{
    public function __invoke(): Generator
    {
        yield new ElementFixture(
            data: new ViewData(),
        );
    }
}
