<?php declare(strict_types=1);

namespace Gocanto\Attributes;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Assert
{
    /**
     * @throws AttributesException
     */
    public static function assert($value, array $constraints, ?string $error = null): void
    {
        $validator = self::validator();

        $validations = $validator->validate($value, $constraints);

        if (count($validations) === 0) {
            return;
        }

        throw new AttributesException($error ?? "The given value [{$value}] is invalid.");
    }

    public static function validator(): ValidatorInterface
    {
        return Validation::createValidator();
    }
}
