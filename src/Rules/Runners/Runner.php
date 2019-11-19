<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules\Runners;

interface Runner
{
    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @param mixed $value
     * @return bool
     */
    public function canReject($value): bool;
}
