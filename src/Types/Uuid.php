<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;
use Symfony\Component\Validator\Constraints\Uuid as UuidConstraint;

class Uuid implements Type
{
    private string $value;

    /**
     * @param mixed $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self
    {
        $uuid = new static();
        $uuid->value = $uuid->parse($value);

        return $uuid;
    }

    /**
     * @param mixed $value
     * @return string
     * @throws AttributesException
     */
    private function parse($value): string
    {
        $constraints = new Constraints([
            new UuidConstraint(),
        ]);

        Assert::assert($value, $constraints, "The given uuid [{$value}] is invalid.");

        return $value;
    }

    public function get(): string
    {
        return $this->value;
    }
}
