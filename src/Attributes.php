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
use Gocanto\Attributes\Support\Arr;
use Gocanto\Attributes\Validator\Validator;
use Gocanto\Attributes\Validator\ValidatorManager;

abstract class Attributes
{
    /** @var array */
    private $data;
    /** @var Validator|null */
    private $validator;

    /**
     * @param array<string, mixed> $data
     * @throws AttributesException
     */
    public function __construct(array $data)
    {
        $this->guard($data);

        $this->data = $data;
    }

    /**
     * @param array<string, mixed> $data
     * @throws AttributesException
     */
    private function guard(array $data): void
    {
        if (empty($data)) {
            throw new AttributesException('The given attributes data cannot be empty.');
        }

        $validator = $this->getValidator();

        if ($validator->isEmpty()) {
            return;
        }

        $validator->validate($data);
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    public function withValidator(Validator $validator): self
    {
        $attributes = clone $this;

        $attributes->validator = $validator;

        return $attributes;
    }

    /**
     * @return Validator
     * @throws AttributesException
     */
    public function getValidator(): Validator
    {
        if ($this->validator !== null) {
            return $this->validator;
        }

        $rules = new RulesCollection(
            $this->getValidationRules()
        );

        $this->validator = new ValidatorManager($rules);

        return $this->validator;
    }

    /**
     * @return array<string, Constraint>
     */
    protected function getValidationRules(): array
    {
        return [];
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
