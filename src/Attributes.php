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

use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\RulesCollection;

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
        $this->guard($data);

        $this->data = $data;
    }

    /**
     * @param array $data
     * @throws AttributeException
     */
    private function guard(array $data): void
    {
        $rules = new RulesCollection(
            $this->getValidationRules()
        );

        if ($rules->isEmpty()) {
            return;
        }

        if (empty($data)) {
            throw new AttributeException('The given data is invalid.');
        }

        $validator = new Validator($rules);

        $validator->validate($data);
    }

    /**
     * @return Constraint[]
     */
    abstract public function getValidationRules(): array;

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
