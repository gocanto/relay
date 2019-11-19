<?php

declare(strict_types=1);

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
     * @param Rule $rule
     */
    public function add(Rule $rule): void
    {
        $this->rules[$rule->getTarget()] = $rule;
    }

    /**
     * @param array $rules
     * @throws RuleException
     */
    public function addMany(array $rules): void
    {
        foreach ($rules as $rule) {
            if (!$rule instanceof Rule) {
                throw new RuleException('The given rules is invalid.');
            }

            $this->add($rule);
        }
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
        return isset($this->rules[$key]);
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
