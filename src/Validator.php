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

use Gocanto\Attributes\Rules\Rule;
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
    public function run(array $data): void
    {
        if ($this->rules->isEmpty()) {
            return;
        }

        foreach ($data as $target => $value) {
            $rule = $this->rules->findByTarget($target);

            if ($rule !== null) {
                $this->assertDataIntegrity($rule, $value);
            }
        }
    }

    /**
     * @param Rule $rule
     * @param $value
     * @throws AttributeException
     */
    private function assertDataIntegrity(Rule $rule, $value): void
    {
        $runners = $rule->getRunners();

        foreach ($runners->all() as $runner) {
            if ($runner->canReject($value)) {
                throw new AttributeException("The given target [{$rule->getTarget()}] value is invalid.");
            }
        }
    }
}
