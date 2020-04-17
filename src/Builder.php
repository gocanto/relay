<?php declare(strict_types=1);

namespace Gocanto\Attributes;

use Gocanto\Attributes\Support\AttributesCollection;
use Gocanto\Attributes\Support\PromotersCollection;

class Builder
{
    private AttributesCollection $attributes;

    private PromotersCollection $promoters;

    public function __construct(AttributesCollection $attributes, PromotersCollection $promoters)
    {
        $this->attributes = $attributes;
        $this->promoters = $promoters;
    }

    /**
     * @param string $field
     * @return Type|null
     * @throws AttributesException
     */
    public function build(string $field): ?Type
    {
        $promoter = $this->promoters->get($field);
        $attribute = $this->attributes->get($field);

        if ($attribute === null && ($promoter !== null && $promoter->isRequired())) {
            throw new AttributesException("The given field [{$field}] is required.");
        }

        if ($attribute === null) {
            return null;
        }

        return $attribute;
    }
}
