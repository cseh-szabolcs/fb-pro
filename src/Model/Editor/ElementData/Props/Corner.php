<?php

namespace App\Model\Editor\ElementData\Props;

use Symfony\Component\Serializer\Attribute\Groups;

class Corner
{
    #[Groups(['editor'])]
    public bool $equal = true;

    public function __construct(
        #[Groups(['editor'])]
        public int|string $topLeft,
        #[Groups(['editor'])]
        public int|string|null $topRight = null,
        #[Groups(['editor'])]
        public int|string|null $bottonRight = null,
        #[Groups(['editor'])]
        public int|string|null $bottomLeft = null,
        bool $equal = true,
    ) {
        $this->equal = $equal;
    }

    public function topLeftValue(): int|string
    {
        return $this->topLeft;
    }

    public function topRightValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->topLeft
            : ($this->topRight ?? $default);
    }

    public function bottomRightValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->topLeft
            : ($this->bottonRight ?? $default);
    }

    public function bottomLeftValue(string|int $default = 0): int|string
    {
        return $this->equal
            ? $this->topLeft
            : ($this->bottomLeft ?? $default);
    }
}
