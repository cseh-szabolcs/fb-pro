<?php

namespace App\Contracts\Entity\Editor;

use App\Entity\Editor\Element\DocumentElement;

interface DocumentAwareInterface
{
    public function getDocument(): DocumentElement;
}
