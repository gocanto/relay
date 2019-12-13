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

use Gocanto\Attributes\Runners\Runner;
use Gocanto\Attributes\Runners\RunnersCollection;

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
            $this->runners = new RunnersCollection([$runner->getIdentifier() => $runner]);
        }

        if ($this->runners->has($runner->getIdentifier())) {
            return;
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

    /**
     * @return RunnersCollection
     */
    public function getRunners(): RunnersCollection
    {
        return $this->runners;
    }

    private function __construct()
    {
    }
}
