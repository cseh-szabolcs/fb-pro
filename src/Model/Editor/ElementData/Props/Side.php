<?php

namespace App\Model\Editor\ElementData\Props;

use Symfony\Component\Serializer\Attribute\Groups;

class Side
{
    #[Groups(['editor'])]
    public bool $equal = true;

    public function __construct(
        #[Groups(['editor'])]
        public int|string $top,
        #[Groups(['editor'])]
        public int|string|null $right = null,
        #[Groups(['editor'])]
        public int|string|null $bottom = null,
        #[Groups(['editor'])]
        public int|string|null $left = null,
        bool $equal = true,
    ) {
        $this->equal = $equal;
    }

    public function topValue(): int|string
    {
        return $this->top;
    }

    public function rightValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->top
            : ($this->right ?? $default);
    }

    public function bottomValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->top
            : ($this->bottom ?? $default);
    }

    public function leftValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->top
            : ($this->left ?? $default);
    }
}
