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
    private $rulesCollection;

    /**
     * @param RulesCollection $rulesCollection
     */
    public function __construct(RulesCollection $rulesCollection)
    {
        $this->rulesCollection = $rulesCollection;
    }

    /**
     * @param array $data
     * @throws AttributeException
     */
    public function validate(array $data): void
    {
        foreach ($data as $target => $value) {
            $rule = $this->rulesCollection->findByTarget($target);

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
                throw new AttributeException(
                    "The given value [{$rule->getTarget()}] is invalid based on the [{$runner->getIdentifier()}] rule."
                );
            }
        }
    }
}
