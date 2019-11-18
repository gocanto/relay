<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;

class DummyAttributes extends Attributes
{
    /**
     * @return array
     */
    public function getFillable(): array
    {
        return [
            'foo',
            'bar',
        ];
    }
}
