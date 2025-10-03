<?php

namespace App\Contracts;

interface EmailAwareInterface
{
    public function getEmail(): string;
}
