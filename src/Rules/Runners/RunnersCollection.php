<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules\Runners;

use Gocanto\Attributes\Rules\RuleException;

class RunnersCollection
{
    /** @var Runner[] */
    private $runners = [];

    /**
     * @param Runner[] $runner
     * @throws RuleException
     */
    public function __construct(array $runner)
    {
        $this->addMany($runner);
    }

    /**
     * @param Runner $runner
     * @throws RuleException
     */
    public function add(Runner $runner): void
    {
        if (array_key_exists($runner->getIdentifier(), $this->runners)) {
            throw new RuleException('The given runner is already added.');
        }

        $this->runners[$runner->getIdentifier()] = $runner;
    }

    /**
     * @param Runner[] $runners
     * @throws RuleException
     */
    public function addMany(array $runners): void
    {
        foreach ($runners as $rule) {
            $this->add($rule);
        }
    }

    /**
     * @return Runner[]
     */
    public function all(): array
    {
        return $this->runners;
    }
}
