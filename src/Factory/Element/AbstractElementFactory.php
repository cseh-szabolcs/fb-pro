<?php

namespace App\Factory\Element;

use Generator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.factory.element')]
abstract class AbstractElementFactory
{
    abstract public function __invoke(): Generator;
}
