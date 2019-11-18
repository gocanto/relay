<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

interface Verifier
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value): bool;

    /**
     * @param mixed $value
     * @return bool
     */
    public function isInvalid($value): bool;
}
