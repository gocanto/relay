<?php declare(strict_types=1);

namespace Gocanto\Attributes;

class Value
{
    private array $constraints;

    private string $key;

    /** @var mixed */
    private $value;

    public function __construct(string $key, $value, array $constraints)
    {
        $this->key = $key;
        $this->value = $value;
        $this->constraints = $constraints;
    }

    /**
     * @return array
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
