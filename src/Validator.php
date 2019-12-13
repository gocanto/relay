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

use Gocanto\Attributes\Rules\ConstraintsCollection;
use Gocanto\Attributes\Rules\RulesCollection;

class Validator
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
     * @param array $data
     * @throws AttributeException
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
     * @throws AttributeException
     */
    private function assertDataIntegrity(ConstraintsCollection $constraints, string $field, $value): void
    {
        foreach ($constraints->get() as $constraints) {
            if ($constraints->canReject($value)) {
                $error = "The given [{$field}] value does not abide by [{$constraints->getIdentifier()}] rule.";

                throw new AttributeException($error);
            }
        }
    }
}
