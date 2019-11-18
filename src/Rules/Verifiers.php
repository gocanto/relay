<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

use Gocanto\Attributes\AttributeException;

class Verifiers
{
    /** @var Verifier[] */
    private $verifiers;

    /**
     * @param array $verifiers
     */
    public function addMany(array $verifiers): void
    {
        foreach ($verifiers as $verifier) {
            $this->add($verifier);
        }
    }

    /**
     * @param Verifier $verifier
     */
    public function add(Verifier $verifier): void
    {
        $this->verifiers[] = $verifier;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function verify($value): bool
    {
        foreach ($this->verifiers as $verifier) {
            if ($verifier->isInvalid($value)) {
                return false;
            }
        }

        return true;
    }
}
