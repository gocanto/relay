<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

class Mixed implements Type
{
    public const IDENTIFIER = 'mixed';

    public function getConstraint(): array
    {
        return [];
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }
}
