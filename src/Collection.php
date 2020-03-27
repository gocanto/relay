<?php

declare(strict_types=1);

namespace Gocanto\Attributes;

use Gocanto\Attributes\Support\Arr;

class Collection
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array|mixed|null
     */
    public function get(string $key)
    {
        return Arr::get($this->items, $key);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
