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
     * @return bool
     */
    public function canReject(): bool;
}
