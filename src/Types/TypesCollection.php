<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\Support\Arr;

class TypesCollection
{
    /** @var array */
    private array $types;

    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function isEmpty(): bool
    {
        return count($this->types) === 0;
    }

    public function isOptional(string $field): bool
    {
        $types = Arr::get($this->types, $field);

        if ($types === null) {
            return true;
        }

        return Arr::has($types, Optional::class);
    }

    public function get(string $field): string
    {
        $type = array_filter(Arr::get($this->types, $field), function (string $value) {
            return $value !== Optional::class;
        });

        return $type[0];
    }
}
