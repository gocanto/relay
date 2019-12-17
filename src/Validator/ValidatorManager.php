<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes\Validator;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\ConstraintsCollection;
use Gocanto\Attributes\Rules\RulesCollection;

final class ValidatorManager implements Validator
{
    /** @var RulesCollection */
    private $rules;

    /**
     * @param RulesCollection $rules
     */
    public function __construct(RulesCollection $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->rules->isEmpty();
    }

    /**
     * @param array<string, mixed> $data
     * @throws AttributesException
     */
    public function validate(array $data): void
    {
        foreach ($data as $field => $value) {
            $constraints = $this->rules->getFor($field);

            if ($constraints !== null && $constraints->isNotEmpty()) {
                $this->assertDataIntegrity($constraints, $field, $value);
            }
        }
    }

    /**
     * @param ConstraintsCollection $constraints
     * @param string $field
     * @param mixed $value
     * @throws AttributesException
     */
    private function assertDataIntegrity(ConstraintsCollection $constraints, string $field, $value): void
    {
        foreach ($constraints->get() as $constraint) {
            $constraint->assert(
                $value,
                "The given [{$field}] value does not abide by [{$constraint->getIdentifier()}] rule."
            );
        }
    }
}
