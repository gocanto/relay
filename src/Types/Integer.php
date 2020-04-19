<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;

class Integer implements Type
{
    private int $value;

    private function __construct()
    {
    }

    /**
     * @param mixed $value
     * @return Type
     * @throws AttributesException
     */
    public static function make($value): Type
    {
        $integer = new static();
        $integer->value = $integer->parse($value);

        return $integer;
    }

    /**
     * @param string|int|mixed $value
     * @return int
     * @throws AttributesException
     */
    private function parse($value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if ($this->canBeInteger($value)) {
            return (int) $value;
        }

        $ref = $this->isNotAllowed($value) ? '' : "[{$value}]";

        throw new AttributesException("The given number {$ref} is invalid.");
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function canBeInteger($value): bool
    {
        if (!is_string($value) || $this->isNotAllowed($value)) {
            return false;
        }

        $candidate = (int) $value;

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

    public function get(): int
    {
        return $this->value;
    }
}
