<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\Assert;
use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

class Url implements Type
{
    public const IDENTIFIER = 'url';

    private string $value;

    /**
     * @throws AttributesException
     */
    public function __construct(string $value)
    {
        Assert::assert($value, $this->getConstraint(), "The given url [{$value}] is invalid.");

        $this->value = $value;
    }

    public function getConstraint(): array
    {
        return [
            new UrlConstraint(),
        ];
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function get(): string
    {
        return $this->value;
    }
}
