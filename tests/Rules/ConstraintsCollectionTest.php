<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\ConstraintsCollection;
use Mockery;
use PHPUnit\Framework\TestCase;

class ConstraintsCollectionTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidData()
    {
        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->andReturn('foo');

        $collection = new ConstraintsCollection('foo', [$constraint]);

        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->isNotEmpty());

        $this->assertEquals($collection->get(), ['foo' => $constraint]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicateConstraints()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/already exists/');

        $constraintA = Mockery::mock(Constraint::class);
        $constraintA->shouldReceive('getIdentifier')->andReturn('foo');

        $constraintB = Mockery::mock(Constraint::class);
        $constraintB->shouldReceive('getIdentifier')->andReturn('foo');

        $collection = new ConstraintsCollection('foo', [$constraintA]);
        $collection->add($constraintB);
    }
}
