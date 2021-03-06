<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;

class Decimal implements Type
{
    private float $value;

    private function __construct()
    {
    }

    /**
     * @param mixed $value
     * @return self
     * @throws AttributesException
     */
    public static function make($value): self
    {
        $decimal = new static();
        $decimal->value = $decimal->parse($value);

        return $decimal;
    }

    /**
     * @param string|float|mixed $value
     * @return float
     * @throws AttributesException
     */
    private function parse($value): float
    {
        if (is_float($value) || is_int($value)) {
            return (float) $value;
        }

        if ($this->canBeDecimal($value)) {
            return (float) $value;
        }

        $ref = $this->isNotAllowed($value) ? '' : '[' . $value . ']';

        throw new AttributesException("The given number {$ref} is invalid.");
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function canBeDecimal($value): bool
    {
        if (!is_string($value) || $this->isNotAllowed($value)) {
            return false;
        }

        $candidate = (float) $value;

        return ((string) $candidate) === $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isNotAllowed($value): bool
    {
        return is_object($value) || is_callable($value);
    }

    public function get(): float
    {
        return $this->value;
    }
}
