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

use Gocanto\Attributes\Types\Mixed;
use Gocanto\Attributes\Types\Type;
use Gocanto\Attributes\Types\TypesCollection;

abstract class Attributes
{
    private Collection $attributes;

    private TypesCollection $types;

    /**
     * @param array $data
     * @param array $types
     * @throws AttributesException
     */
    public function __construct(array $data = [], array $types = [])
    {
        $this->parse($data, $types);
    }

    /**
     * @param array $data
     * @param array $types
     * @throws AttributesException
     */
    private function parse(array $data = [], array $types = []): void
    {
        $attributes = new Collection();
        $types = new TypesCollection($types);

        foreach ($data as $field => $value) {
            $attributes->add($field, $types->getTypeFor($field, $value));
        }

        $this->attributes = $attributes;
        $this->types = $types;
    }

    /**
     * @param string $field
     * @return Type|null
     * @throws AttributesException
     */
    public function get(string $field): ?Type
    {
        $promoter = $this->types->getPromoterFor($field);

        if ($promoter === null) {
            return new Mixed($field);
        }

        $type = $this->attributes->get($field);

        if (is_a($type, $promoter->getCandidate())) {
            return $type;
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
