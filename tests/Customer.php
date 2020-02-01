<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Validators\Required;

class Customer extends Attributes
{
    public function getValidationRules(): array
    {
        return [
            'first_name' => [new Required],
        ];
    }
}
