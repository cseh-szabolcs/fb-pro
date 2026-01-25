<?php

namespace App\Contracts\Editor;

use App\Model\Editor\ElementData\BaseData;

interface ElementDataAwareInterface
{
    public function getData(): BaseData;
}
