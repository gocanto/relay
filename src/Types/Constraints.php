<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Support\Arr;
use Symfony\Component\Validator\Constraint;

class Constraints
{
    /** @var Constraint[] */
    private array $constraints = [];

    /**
     * @param array $constraints
     * @throws AttributesException
     */
    public function __construct(array $constraints)
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
        $key = get_class($constraint);

        if (Arr::exists($this->constraints, $key)) {
            throw new AttributesException("The given constraint [{$key}] already exists.");
        }

        $this->constraints[$key] = $constraint;
    }

    public function get(string $key): ?Constraint
    {
        return $this->constraints[$key] ?? null;
    }

    public function toArray(): array
    {
        return $this->constraints;
    }
}
