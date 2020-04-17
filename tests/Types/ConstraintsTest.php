<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Types\Constraints;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class ConstraintsTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsEmptyValues(): void
    {
        $collection = new Constraints($data = []);

        $this->assertSame($data, $collection->toArray());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itContainsValidConstraints(): void
    {
        $constraint = Mockery::mock(Constraint::class);

        $collection = new Constraints([$constraint]);

        $this->assertNull($collection->get('foo'));

        $this->assertCount(1, $collection->toArray());
        $this->assertSame($constraint, $collection->get(get_class($constraint)));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicatedConstraints(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/already exists/');

        $constraint = Mockery::mock(Constraint::class);

        new Constraints([$constraint, $constraint]);
    }
}
