<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes;

use Gocanto\Attributes\Support\AttributesCollection;
use Gocanto\Attributes\Types\Mixed;
use Gocanto\Attributes\Support\PromotersCollection;

abstract class Attributes
{
    private AttributesCollection $attributes;

    private PromotersCollection $promoters;

    /**
     * @param array $data
     * @param array $promoters
     * @throws AttributesException
     */
    public function __construct(array $data = [], array $promoters = [])
    {
        $this->parse($data, $promoters);
    }

    /**
     * @param array $data
     * @param array $promoters
     * @throws AttributesException
     */
    private function parse(array $data = [], array $promoters = []): void
    {
        $attributes = new AttributesCollection();
        $promoters = new PromotersCollection($promoters);

        foreach ($data as $field => $value) {
            $attributes->add($field, $promoters->getTypeFor($field, $value));
        }

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

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes->toArray();
    }
}
