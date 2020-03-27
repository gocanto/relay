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

use Gocanto\Attributes\Types\TypesCollection;

abstract class Attributes
{
    private Collection $data;

    private TypesCollection $types;

    public function __construct(array $data, array $types = [])
    {
        $this->types = new TypesCollection($types);

        $this->data = new Collection(
            $this->parse($data)
        );
    }

    private function parse(array $payload): array
    {
        $data = [];

        foreach ($payload as $field => $value) {
            $data[$field] = $this->types->getTypeFor($field, $value);
        }

        return $data;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data->get($key);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->data->toArray();
    }
}
