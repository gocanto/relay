<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

class Url implements Type
{
    private string $value;

    private function __construct()
    {
    }

    /**
     * @param $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self
    {
        $url = new static();
        $url->value = $url->parse($value);

        return $url;
    }

    /**
     * @param $value
     * @return string
     * @throws AttributesException
     */
    private function parse($value): string
    {
        $constraints = new Constraints([
            new UrlConstraint(),
        ]);

        Assert::assert($value, $constraints, "The given url [{$value}] is invalid.");

        return $value;
    }

    public function get(): string
    {
        return $this->value;
    }
}
