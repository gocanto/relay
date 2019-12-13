<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes\Rules\Runners;

use Gocanto\Attributes\Rules\RuleException;

class RunnersCollection
{
    /** @var Runner[] */
    private $runners = [];

    /**
     * @param Runner[] $runners
     * @throws RuleException
     */
    public function __construct(array $runners)
    {
        $this->addMany($runners);
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
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->runners[$key]);
    }

    /**
     * @return Runner[]
     */
    public function all(): array
    {
        return $this->runners;
    }
}
