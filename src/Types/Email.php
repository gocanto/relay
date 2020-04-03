<?php declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class Email implements Type
{
    private string $value;

    /**
     * @param $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self
    {
        Assert::assert($value, self::constraints(), "The given email [{$value}] is invalid.");

        $email = new static();
        $email->value = $value;

        return $email;
    }

    /**
     * @return Constraints
     * @throws AttributesException
     */
    private static function constraints(): Constraints
    {
        return new Constraints([
            new EmailConstraint(),
        ]);
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
