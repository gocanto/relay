<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;
use Symfony\Component\Validator\Constraints\Type as TypeValidator;

class Boolean implements Type
{
    public const TRULY = [1, '1', 'true', 't', 'y', 'yes'];
    public const FALSY = [0, '0', 'false', 'f', 'n', 'no'];

    private bool $value;

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
        $boolean = new static();
        $boolean->value = $boolean->parse($value);

        return $boolean;
    }

    /**
     * @param mixed $value
     * @return bool
     * @throws AttributesException
     */
    private function parse($value): bool
    {
        $value = is_string($value) ? mb_strtolower($value) : $value;

        if (in_array($value, self::TRULY, true)) {
            return true;
        }

        if (in_array($value, self::FALSY, true)) {
            return false;
        }

        $constraints = new Constraints([
            new TypeValidator(['type' => 'bool']),
        ]);

        Assert::assert($value, $constraints, "The given text [{$value}] is invalid.");

        return (bool) $value;
    }

    public function isTrue(): bool
    {
        return $this->value === true;
    }

    public function isFalse(): bool
    {
        return !$this->isTrue();
    }

    public function get(): bool
    {
        return $this->value;
    }
}
