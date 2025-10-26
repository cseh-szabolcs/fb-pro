<?php

namespace App\Model\List;

use App\Contracts\ToArrayInterface;

final readonly class Result implements ToArrayInterface
{
    public function __construct(
        public array $items,
        public int $total = 0,
    ) {}

    public function getCount(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->getCount();
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'total' => $this->total,
            'count' => $this->getCount(),
            'empty' => $this->isEmpty(),
        ];
    }
}
