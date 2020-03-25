<?php declare(strict_types=1);

namespace Gocanto\Attributes;

class Payload
{
    private array $data = [];

    public function __construct(array $data)
    {
        $this->assert($data);
    }

    private function assert(array $data): void
    {
        foreach ($data as $value) {
            foreach ($value->getConstraints() as $constraint) {
                $this->data[$value->getKey()] = $constraint::create($value->getValue());
            }
        }
    }

    public function get(string $field)
    {
        return $this->data[$field];
    }
}
