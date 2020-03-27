<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

class Mixed implements Type
{
    public const IDENTIFIER = 'mixed';

    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getConstraint(): array
    {
        return [];
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
