<?php declare(strict_types=1);

namespace Gocanto\Attributes\Validator;

use Gocanto\Attributes\AttributesException;

interface Validator
{
    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param array $data
     * @throws AttributesException
     */
    public function validate(array $data): void;
}
