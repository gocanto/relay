<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Types;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Type;
use Throwable;

class Date implements Type
{
    private DateTimeInterface $value;

    private CarbonInterface $carbon;

    /**
     * @param string $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self
    {
        $date = new static();

        try {
            $date->carbon = CarbonImmutable::parse(
                $date->parseDateTime($value)
            );
        } catch (Throwable $exception) {
            throw AttributesException::fromThrowable($exception, "The given datetime [{$value}] is invalid.");
        }

        $date->value = $date->carbon;

        return $date;
    }

    /**
     * @param $value
     * @return string
     * @throws AttributesException
     */
    private function parseDateTime($value): string
    {
        if (is_string($value)) {
            return $value;
        }

        throw new AttributesException("The given datetime value [{$value}] is invalid.");
    }

    public function get(): DateTimeInterface
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function getCarbon(): CarbonInterface
    {
        return $this->carbon;
    }
}
