<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;
use Symfony\Component\Validator\Constraints\Type as TypeValidator;

class Text implements Type
{
    private string $value;

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
        $text = new static();
        $text->value = $text->parse($value);

        return $text;
    }

    /**
     * @param mixed $value
     * @return string
     * @throws AttributesException
     */
    private function parse($value): string
    {
        $constraints = new Constraints([
            new TypeValidator(['type' => 'string']),
        ]);

        Assert::assert($value, $constraints, "The given text [{$value}] is invalid.");

        return $value;
    }

    public function get(): string
    {
        return $this->value;
    }
}
