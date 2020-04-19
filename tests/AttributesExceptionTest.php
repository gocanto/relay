<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests;

use Exception;
use Gocanto\Relay\AttributesException;
use PHPUnit\Framework\TestCase;

class AttributesExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function itBuiltItselfFromThrowable()
    {
        $throwable = new Exception('Foo', 10);
        $exception = AttributesException::fromThrowable($throwable);

        $this->assertSame('Foo', $exception->getMessage());
        $this->assertSame(10, $exception->getCode());
        $this->assertSame($throwable, $exception->getPrevious());
    }
}
