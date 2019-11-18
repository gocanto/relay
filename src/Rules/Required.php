<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

class Required implements Verifier
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value): bool
    {
        return true;
    }
}
