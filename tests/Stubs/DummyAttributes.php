<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Validators\Required;

class DummyAttributes extends Attributes
{
    protected function getValidationRules(): array
    {
        return [
            'name' => [new Required],
        ];
    }
}
