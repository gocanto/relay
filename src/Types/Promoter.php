<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\AttributesException;

class Promoter
{
    private bool $optional = false;
    private string $candidate;

    /**
     * @param string $candidate
     * @throws AttributesException
     */
    private function __construct(string $candidate)
    {
        $this->guard($candidate);

        $this->candidate = $candidate;
    }

    /**
     * @param string $candidate
     * @throws AttributesException
     */
    private function guard(string $candidate): void
    {
        if (class_exists($candidate, true)) {
            return;
        }

        throw new AttributesException("The given candidate [{$candidate}] does not exist.");
    }

    /**
     * @param string $candidate
     * @return Promoter
     * @throws AttributesException
     */
    public static function make(string $candidate): self
    {
        return new static($candidate);
    }

    /**
     * @param string $candidate
     * @return Promoter
     * @throws AttributesException
     */
    public static function optional(string $candidate): self
    {
        $promoter = new static($candidate);
        $promoter->markAsOptional();

        return $promoter;
    }

    public function markAsOptional(): self
    {
        $this->optional = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getCandidate(): string
    {
        return $this->candidate;
    }

    public function build($value): Type
    {
        $type = $this->candidate;

        return new $type($value);
    }
}
