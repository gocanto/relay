<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Validators\Required;
use Gocanto\Attributes\Rules\Validators\StringNotEmpty;

class Customer extends Attributes
{
    public function getValidationRules(): array
    {
        return [
            'first_name' => [new Required()],
            'last_name' => [new StringNotEmpty()],
            'require_value' => [new Required()],
        ];
    }
}
