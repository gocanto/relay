<?php declare(strict_types=1);

namespace Gocanto\Attributes;

use Gocanto\Attributes\Support\AttributesCollection;
use Gocanto\Attributes\Support\PromotersCollection;
use Gocanto\Attributes\Types\Mixed;

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
    public function get(string $field): ?Type
    {
        $abstract = $this->attributes->get($field);
        $promoter = $this->promoters->get($field);

        if ($abstract === null && ($promoter !== null && $promoter->isRequired())) {
            throw new AttributesException("The given field [{$field}] is required.");
        }

        if ($abstract === null) {
            return null;
        }

        if ($abstract instanceof Mixed || is_a($abstract, $promoter->getCandidate())) {
            return $abstract;
        }

        throw new AttributesException("The given field [{$field}] has an invalid type.");
    }
}
