<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\ConstraintsCollection;
use Gocanto\Attributes\Rules\RulesCollection;
use Mockery;
use PHPUnit\Framework\TestCase;

class RulesCollectionTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldValidData()
    {
        $rules = [
            $this->getConstraintMock(),
        ];

        $collection = new RulesCollection([
            'foo' => $rules,
        ]);

        $this->assertFalse($collection->isEmpty());
        $this->assertNull($collection->getFor('bar'));
        $this->assertEquals(new ConstraintsCollection('foo', $rules), $collection->getFor('foo'));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsRulesDataInputWithInvalidKeys()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/[0]/');

        new RulesCollection(['']);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicateFieldRulesSet()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/constraints already exist/');

        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->andReturn('foo');

        $collection = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $collection->add('foo', [$constraint]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstEmptyConstraints()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/constraints are required/');

        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->andReturn('foo');

        $collection = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $collection->add('bar', []);
    }

    /**
     * @return Constraint
     */
    private function getConstraintMock(): Constraint
    {
        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->andReturn('foo');

        return $constraint;
    }
}
