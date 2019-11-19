<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

use Gocanto\Attributes\Rules\Runners\Runner;
use Gocanto\Attributes\Rules\Runners\RunnersCollection;

class Rule
{
    /** @var string */
    private $target;
    /** @var RunnersCollection */
    private $runners;

    /**
     * @param string $field
     * @return Rule
     */
    public static function make(string $field): Rule
    {
        $rule = new static;

        $rule->target = $field;

        return $rule;
    }

    /**
     * @param Runner[] $runners
     * @throws RuleException
     */
    public function addRunners(array $runners): void
    {
        if ($this->runners === null) {
            $this->runners = new RunnersCollection($runners);
        }

        $this->runners->addMany($runners);
    }

    /**
     * @param Runner $runner
     * @throws RuleException
     */
    public function addRunner(Runner $runner): void
    {
        if ($this->runners === null) {
            $this->runners = new RunnersCollection([$runner]);
        }

        $this->runners->add($runner);
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    private function __construct()
    {
    }
}
