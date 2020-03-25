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

abstract class Attributes
{
    private array $data;

    public function __construct(array $data, array $rules = [])
    {
        $this->data = $this->parse($data, $rules);
    }

    private function parse(array $data, array $rules)
    {
        $sanitized = [];

        foreach ($data as $field => $item) {
            $type = Arr::get($rules, $field);

            if ($type === null) {
                $sanitized[$field] = $item;
            } else {
                $sanitized[$field] = $type[0]::create($item);
            }
        }

        return $sanitized;
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
