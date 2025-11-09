<?php

namespace App\Contracts\Entity;

use App\Entity\Editor\Element\DocumentElement;

interface EditorDocumentAwareInterface
{
    public function getDocumentElement(): DocumentElement;
}
