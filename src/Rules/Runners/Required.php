<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules\Runners;

class Required implements Runner
{
    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'required';
    }

    /**
     * @return bool
     */
    public function canReject(): bool
    {
        return true;
    }
}
