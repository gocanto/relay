<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes\Rules;

final class RulesCollection
{
    /** @var Rule[] */
    private $rules = [];

    /**
     * @param Rule[] $rules
     * @throws RuleException
     */
    public function __construct(array $rules)
    {
        $this->addMany($rules);
    }

    /**
     * @param array $rules
     * @throws RuleException
     */
    public function addMany(array $rules): void
    {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    /**
     * @param Rule $rule
     * @throws RuleException
     */
    public function add(Rule $rule): void
    {
        if (array_key_exists($rule->getTarget(), $this->rules)) {
            throw new RuleException('The given rule is already added.');
        }

        $this->rules[$rule->getTarget()] = $rule;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->rules) === 0;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return !empty($this->rules[$key]);
    }

    /**
     * @param string $target
     * @return Rule|null
     */
    public function findByTarget(string $target): ?Rule
    {
        return $this->rules[$target] ?? null;
    }

    /**
     * @return Rule[]
     */
    public function all(): array
    {
        return $this->rules;
    }
}
