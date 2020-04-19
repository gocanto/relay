<?php

declare(strict_types=1);

namespace Gocanto\Relay\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Type;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class Email implements Type
{
    private string $value;

    private function __construct()
    {
    }

    /**
     * @param mixed $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self
    {
        $email = new static();
        $email->value = $email->parse($value);

        return $email;
    }

    /**
     * @param mixed $value
     * @return string
     * @throws AttributesException
     */
    private function parse($value): string
    {
        $constraints = new Constraints([
            new EmailConstraint(),
        ]);

        Assert::assert($value, $constraints, "The given email [{$value}] is invalid.");

        return $value;
    }

    public function getDomain(): string
    {
        [, $domain] = explode('@', $this->value);

        return $domain;
    }

    public function getTLD(): string
    {
        [, $tld] = explode('.', $this->getDomain());

        return $tld;
    }

    public function get(): string
    {
        return $this->value;
    }
}
