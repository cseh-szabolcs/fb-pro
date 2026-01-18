<?php

namespace App\Factory\Element;

use App\Model\Editor\ElementData\ViewData;
use App\Model\Editor\Fixture\ElementFixture;
use Generator;

class ViewFactory extends AbstractElementFactory
{
    public function __invoke(): Generator
    {
        yield new ElementFixture(
            data: new ViewData(),
        );
    }
}
