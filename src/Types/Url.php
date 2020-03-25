<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\Assert;
use Gocanto\Attributes\AttributesException;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

class Url implements Type
{
    private string $value;

    private function __construct()
    {
    }

    /**
     * @throws AttributesException
     */
    public static function create(string $value): Url
    {
        $url = new static();

        Assert::assert($value, $url->getConstraint(), "The given url [{$value}] is invalid.");

        $url->value = $value;

        return $url;
    }

    public function getConstraint(): array
    {
        return [
            new UrlConstraint(),
        ];
    }

    public function getIdentifier(): string
    {
        return 'url';
    }

    public function get(): string
    {
        return $this->value;
    }
}
