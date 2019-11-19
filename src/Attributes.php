<?php

declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes;

use Gocanto\Attributes\Rules\Validator;

abstract class Attributes
{
    /** @var array */
    private $data;

    /**
     * @param array $data
     * @throws AttributeException
     */
    public function __construct(array $data)
    {
        $this->data = $this->validated($data);
    }

    /**
     * @param array $data
     * @return array
     * @throws AttributeException
     */
    private function validated(array $data): array
    {
        $validator = $this->getValidator();

        $validator->validate($data);

        return $data;
    }

    /**
     * @return Validator
     */
//    abstract public function getValidator(): Validator;

    /**
     * @param array $seeds
     * @return bool
     */
    public function filled(...$seeds): bool
    {
        foreach ($seeds as $seed) {
            if (!array_key_exists($seed, $this->data)) {
                return false;
            }

            if (empty($this->data[$seed])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
