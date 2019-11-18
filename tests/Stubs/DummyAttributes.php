<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Rule;
use Gocanto\Attributes\Rules\Required;
use Gocanto\Attributes\Rules\Validator;

class DummyAttributes extends Attributes
{
    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return new Validator([
            Rule::make('foo')->addVerifier(new Required),
            Rule::make('bar'),
        ]);
    }
}
