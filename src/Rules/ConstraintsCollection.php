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

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Support\Arr;

final class ConstraintsCollection
{
    /** @var string */
    private $field;
    /** @var Constraint[] */
    private $constraints = [];

    /**
     * @param string $field
     * @param Constraint[] $constraints
     * @throws AttributesException
     */
    public function __construct(string $field, array $constraints)
    {
        $this->field = $field;
        $this->addMany($constraints);
    }

    /**
     * @param Constraint[] $constraints
     * @throws AttributesException
     */
    public function addMany(array $constraints): void
    {
        foreach ($constraints as $constraint) {
            $this->add($constraint);
        }
    }

    /**
     * @param Constraint $constraint
     * @throws AttributesException
     */
    public function add(Constraint $constraint): void
    {
        if ($this->has($constraint)) {
            throw new AttributesException(sprintf('The given constraint [%s] was already attached to [%s].', [
                $constraint->getIdentifier(),
                $this->field,
            ]));
        }

        $this->constraints[$constraint->getIdentifier()] = $constraint;
    }

    /**
     * @param Constraint $constraint
     * @return bool
     */
    public function has(Constraint $constraint): bool
    {
        return Arr::exists($this->constraints, $constraint->getIdentifier());
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->constraints) === 0;
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return Constraint[]
     */
    public function get(): array
    {
        return $this->constraints;
    }
}
