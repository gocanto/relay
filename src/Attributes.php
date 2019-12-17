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
     * @param Validator|null $validator
     * @throws AttributesException
     */
    public function __construct(array $data, Validator $validator = null)
    {
        $this->validator = $validator ?? $this->resolveValidator();

        $this->guard($data);

        $this->data = $data;
    }

    /**
     * @return Validator
     * @throws AttributesException
     */
    private function resolveValidator(): Validator
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
     * @param array<string, mixed> $data
     * @throws AttributesException
     */
    private function guard(array $data): void
    {
        if (empty($data)) {
            throw new AttributesException('The given data is invalid.');
        }

        $validator = $this->resolveValidator();

        if ($validator->isEmpty()) {
            return;
        }

        $validator->validate($data);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return array<int|string, Constraint>
     */
    protected function getValidationRules(): array
    {
        return [];
    }
}
