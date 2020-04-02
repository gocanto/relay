<?php

declare(strict_types=1);

namespace Gocanto\Attributes;

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
        if (!class_exists($candidate, true)) {
            throw new AttributesException("The given candidate [{$candidate}] does not exist.");
        }

        if (!is_a($candidate, Type::class, true)) {
            throw new AttributesException("The given candidate [{$candidate}] is not a valid type.");
        }
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

    public function isRequired(): bool
    {
        return $this->optional === false;
    }

    public function build($value): Type
    {
        /** @var Type $type */
        $type = $this->candidate;

        return $type::make($value);
    }
}
