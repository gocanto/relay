<?php

declare(strict_types=1);

namespace Gocanto\Relay\Support;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Any;

class PromotersCollection
{
    /** @var array */
    private array $promoters = [];

    /**
     * @param array $promoters
     * @throws AttributesException
     */
    public function __construct(array $promoters)
    {
        foreach ($promoters as $field => $promoter) {
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
        if (Arr::exists($this->promoters, $field)) {
            throw new AttributesException("The given promoter [{$field}] already exists.");
        }

        $this->promoters[$field] = $promoter;
    }

    public function isEmpty(): bool
    {
        return count($this->promoters) === 0;
    }

    public function has(string $field): bool
    {
        return Arr::exists($this->promoters, $field);
    }

    public function missing(string $field): bool
    {
        return !Arr::exists($this->promoters, $field);
    }

    public function get(string $field): ?Promoter
    {
        return $this->promoters[$field] ?? null;
    }

    /**
     * @param string $field
     * @param Any $value
     * @return Type
     * @throws AttributesException
     */
    public function getTypeFor(string $field, $value): Type
    {
        $promoter = $this->get($field);

        if ($promoter === null) {
            return Any::make($value);
        }

        return $promoter->build($value);
    }

    public function toArray(): array
    {
        return $this->promoters;
    }
}
