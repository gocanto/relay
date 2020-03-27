<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Support;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Types\Type;

class AttributesCollection
{
    /** @var Type[] */
    private array $items = [];

    /**
     * @param array $items
     * @throws AttributesException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $field => $item) {
            $this->add($field, $item);
        }
    }

    /**
     * @param string $field
     * @param Type $type
     * @throws AttributesException
     */
    public function add(string $field, Type $type): void
    {
        if (Arr::exists($this->items, $field)) {
            throw new AttributesException("The given field [{$field}] already exists.");
        }

        $this->items[$field] = $type;
    }

    /**
     * @param string $key
     * @return Type|null
     */
    public function get(string $key): ?Type
    {
        return Arr::get($this->items, $key);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
