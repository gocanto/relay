<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Symfony\Component\Validator\Constraints\Type as TypeValidator;

class Text implements Type
{
    private string $value;

    /**
     * @param $value
     * @return Type
     * @throws AttributesException
     */
    public static function make($value): Type
    {
        Assert::assert($value, self::constraints(), "The given text [{$value}] is invalid.");

        $abstract = new static();
        $abstract->value = $value;

        return $abstract;
    }

    /**
     * @return Constraints
     * @throws AttributesException
     */
    private static function constraints(): Constraints
    {
        return new Constraints([
            new TypeValidator('string'),
        ]);
    }

    public function get(): string
    {
        return $this->value;
    }
}
