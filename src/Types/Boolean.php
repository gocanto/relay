<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Symfony\Component\Validator\Constraints\Type as TypeValidator;

class Boolean implements Type
{
    public const TRULY = [1, '1', true, 'true', 't', 'y', 'yes'];
    public const FALSY = [0, '0', false, 'false', 'f', 'n', 'no'];

    private bool $value;

    /**
     * @param $value
     * @return Type
     * @throws AttributesException
     */
    public static function make($value): Type
    {
        $value = self::parse($value);

        $abstract = new static();
        $abstract->value = $value;

        return $abstract;
    }

    /**
     * @param $value
     * @return bool
     * @throws AttributesException
     */
    private static function parse($value): bool
    {
        $value = is_string($value) ? mb_strtolower($value) : $value;

        if (in_array($value, self::TRULY, true)) {
            return true;
        }

        if (in_array($value, self::FALSY, true)) {
            return false;
        }

        Assert::assert($value, self::constraints(), "The given text [{$value}] is invalid.");

        return $value;
    }

    /**
     * @return Constraints
     * @throws AttributesException
     */
    private static function constraints(): Constraints
    {
        return new Constraints([
            new TypeValidator(['type' => 'bool']),
        ]);
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
