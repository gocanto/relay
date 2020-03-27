<?php declare(strict_types=1);

namespace Gocanto\Attributes\Support;

use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Mixed;

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

    public function has(string $field): bool
    {
        return Arr::exists($this->types, $field);
    }

    public function missing(string $field): bool
    {
        return !Arr::exists($this->types, $field);
    }

    public function getPromoterFor(string $field): ?Promoter
    {
        return Arr::get($this->types, $field);
    }

    public function getTypeFor(string $field, $value): Type
    {
        $promoter = $this->getPromoterFor($field);

        if ($promoter === null) {
            return Mixed::make($value);
        }

        return $promoter->build($value);
    }
}
