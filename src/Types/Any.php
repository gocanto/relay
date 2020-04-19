<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\Type;
use JsonException;

class Any implements Type
{
    /** @var mixed */
    private $value;

    private function __construct()
    {
    }

    public static function make($value): self
    {
        $mixed = new static();
        $mixed->value = $value;

        return $mixed;
    }

    public function get()
    {
        return $this->value;
    }

    public function isArray(): bool
    {
        return is_array($this->value);
    }

    public function isEmpty(): bool
    {
        return $this->isArray()
            ? count($this->value) === 0
            : empty($this->value);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toString(): string
    {
        return $this->isArray()
            ? json_encode($this->value, JSON_THROW_ON_ERROR)
            : (string) $this->value;
    }

    public function toInt(): int
    {
        return (int) $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }
}
