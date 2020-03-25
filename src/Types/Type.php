<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

interface Type
{
    public function getConstraint(): array;

    public function getIdentifier(): string;
}
