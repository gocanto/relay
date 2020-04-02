<?php declare(strict_types=1);

namespace Gocanto\Attributes\Support;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Mixed;

class PromotersCollection
{
    /** @var array */
    private array $types = [];

    /**
     * @param array $types
     * @throws AttributesException
     */
    public function __construct(array $types)
    {
        foreach ($types as $field => $promoter) {
            $this->add($field, $promoter);
        }
    }

    /**
     * @param string $field
     * @param Promoter $promoter
     * @throws AttributesException
     */
    public function add(string $field, Promoter $promoter): void
    {
        if (Arr::exists($this->types, $field)) {
            throw new AttributesException("The given promoter [{$field}] already exists.");
        }

        $this->types[$field] = $promoter;
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

    public function get(string $field): ?Promoter
    {
        return Arr::get($this->types, $field);
    }

    public function getTypeFor(string $field, $value): Type
    {
        $promoter = $this->get($field);

        if ($promoter === null) {
            return Mixed::make($value);
        }

        return $promoter->build($value);
    }
}
