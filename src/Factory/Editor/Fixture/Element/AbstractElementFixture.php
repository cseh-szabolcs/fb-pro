<?php

namespace App\Factory\Editor\Fixture\Element;

use Generator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.fixture.editor.element')]
abstract class AbstractElementFixture
{
    abstract public function __invoke(): Generator;
}
