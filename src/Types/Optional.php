<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

class Optional implements Type
{
    public const IDENTIFIER = 'optional';

    public function getConstraint(): array
    {
        return [];
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }
}
