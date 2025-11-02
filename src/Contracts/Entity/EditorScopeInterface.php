<?php

namespace App\Contracts\Entity;

use App\Constants\Entity\ElementScope;

interface EditorScopeInterface
{
    public function getName(): ElementScope;

    public function getId(): string;
}
