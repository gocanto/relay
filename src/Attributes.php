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

use Gocanto\Attributes\Support\Arr;
use Gocanto\Attributes\Types\TypesCollection;
use Gocanto\Attributes\Types\Type;

abstract class Attributes
{
    private array $data;

    private TypesCollection $types;

    public function __construct(array $data, array $types = [])
    {
        $this->types = new TypesCollection($types);

        $this->data = $this->parse($data);
    }

    private function parse(array $payload): array
    {
        $data = [];

        foreach ($payload as $field => $value) {
            $data[$field] = $this->resolveItem($field, $value);
        }

        return $data;
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    private function resolveItem(string $field, $value)
    {
        if ($this->types->isOptional($field)) {
            return $value;
        }

        /** @var Type $type */
        $type = $this->types->get($field);

        return new $type($value);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return Arr::get($this->data, $key);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
