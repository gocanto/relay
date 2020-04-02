<?php declare(strict_types=1);

namespace Gocanto\Attributes\Support;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Mixed;

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
        return Arr::get($this->promoters, $field);
    }

    public function getTypeFor(string $field, $value): Type
    {
        $promoter = $this->get($field);

        if ($promoter === null) {
            return Mixed::make($value);
        }

        return $promoter->build($value);
    }

    public function toArray(): array
    {
        return $this->promoters;
    }
}
